<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title> @yield('title') | {{ config('app.name') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ url('img/products-logo.png') }}">

        <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @yield('styles')
    </head>
    <body>
        @yield('content')
        @yield('scripts')
    </body>
</html>
