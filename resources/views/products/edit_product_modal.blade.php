<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="edit-id" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="edit-name" id="edit-name" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity in Stock</label>
                        <input type="number" class="form-control" name="edit-quantity" id="edit-quantity" min="0" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price per Item</label>
                        <input type="number" step="0.01" class="form-control" name="edit-price" id="edit-price" min="0" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
