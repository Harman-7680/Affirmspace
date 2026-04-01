<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
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

    @if (session('status'))
        <div id="flash-success"
            style="
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #dcfce7;
            border: 1px solid #22c55e;
            color: #166534;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            text-align: center;
            min-width: 260px;
        ">
            {{ session('status') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-success');
                if (el) el.style.display = 'none';
            }, 5000);
        </script>
    @endif

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
