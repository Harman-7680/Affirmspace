<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AffirmSpace</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('images/welcomepage.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/welcomepage.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600,700|Comfortaa:300,400,700" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/components.css') }}">

    <!-- Layout / Page CSS -->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/pages/chat-application.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @yield('css')
</head>

<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu"
    data-color="bg-gradient-x-purple-blue" data-col="2-columns">

    @include('admin.admin_navbar')
    @include('admin.sidebar')

    <main>
        @yield('content')
    </main>

    @include('admin.edit_profile')
    @include('admin.show_posts')

    <!-- Vendor JS -->
    <script src="{{ asset('admin/app-assets/vendors/js/vendors.min.js') }}"></script>

    <!-- Core JS -->
    <script src="{{ asset('admin/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/core/app.js') }}"></script>

    <!-- Optional / Page JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @yield('script')
</body>

</html>
