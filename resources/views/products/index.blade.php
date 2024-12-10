@extends('layouts.layout')

@section('title')
    Products
@endsection

@section('content')
    <div class="container mt-5 col-md-6 col-lg-5">
        <h2>Products</h2>
        <form id="productForm" action="{{ route('products.store') }}" method="POST" class="container mt-5">
            @csrf
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label>Quantity in Stock</label>
                <input type="number" class="form-control" name="quantity" min="0" value="{{ old('quantity') }}">
            </div>
            <div class="mb-3">
                <label>Price per Item</label>
                <input type="number" step="0.01" class="form-control" name="price" min="0" value="{{ old('price') }}">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>

        <div id="productTable" class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-active">
                        <th>Product Name</th>
                        <th>Quantity in Stock</th>
                        <th>Price per Item</th>
                        <th>Datetime Submitted</th>
                        <th>Total Value Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>${{ number_format($product['price'], 2) }}</td>
                            {{-- <td>${{ $product['price'] }}</td> --}}
                            <td>{{ $product['datetime'] }}</td>
                            <td>${{ number_format($product['total_value'], 2) }}</td>
                            {{-- <td>${{ $product['total_value'] }}</td> --}}
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn text-white" id="{{ $key }}" name="{{ $product['name'] }}" quantity="{{ $product['quantity'] }}" price="{{ $product['price'] }}">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-active">
                        <td colspan="5"><strong>Sum Of Total Value Number</strong></td>
                        <td>
                            <strong> ${{ number_format($totalSum, 2) }} </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('products.edit_product_modal')

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productForm').on('submit', function(e) {
                e.preventDefault();

                console.log($(this).serialize());
                // console.log($('meta[name="X-CSRF-TOKEN"]').attr('content'));

                $('.error').removeClass('error');
                $('.error-message').remove();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.store') }}',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {

                            var errors = xhr.responseJSON.errors;

                            console.log(errors);

                            $.each(errors, function(field, messages) {
                                var $input = $('[name="' + field + '"]');
                                $input.addClass('error');
                                $input.after('<div class="error-message text-danger">' + messages[0] + '</div>');
                            });
                        }
                    }
                });
            });

            $('.edit-btn').on('click', function() {

                var id = $(this).attr('id');
                var name = $(this).attr('name');
                var quantity = $(this).attr('quantity');
                var price = $(this).attr('price');

                // console.log("id:", id, "name:", name, 'quant:', quantity, 'price:', price);

                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-quantity').val(quantity);
                $('#edit-price').val(price);

                $('#editProductModal').modal('show');
            });

            $('#editProductForm').on('submit', function(e) {
                e.preventDefault();

                var id = $('#edit-id').val();
                // console.log(id);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('products.update', ['id' => ':id']) }}".replace(':id', id),
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#editProductModal').modal('hide');
                            alert('Product updated successfully!');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;

                            // console.log(xhr.responseJSON)

                            $.each(errors, function(field, messages) {
                                var $input = $('#' + field);
                                // console.log($input);
                                $input.addClass('error');
                                $input.after('<div class="error-message text-danger">' + messages[0] + '</div>');
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
