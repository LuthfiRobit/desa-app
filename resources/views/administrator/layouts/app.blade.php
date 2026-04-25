<!doctype html>
<html lang="id">
<head>
    <title>@yield('title', 'Dashboard') | Admin Desa Sukorejo</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" href="{{ asset('admin-template/assets/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" />
    
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('admin-template/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/css/custom-style.css') }}" />
    
    @stack('styles')
</head>
<body>
    <!-- [ Pre-loader ] -->
    <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>

    @include('administrator.layouts.partials.sidebar')
    
    @include('administrator.layouts.partials.navbar')

    <!-- [ Main Content ] -->
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    @include('administrator.layouts.partials.footer')

    <!-- Required Js -->
    <script src="{{ asset('admin-template/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/script.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/theme.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/plugins/feather.min.js') }}"></script>

    <script>layout_change('light');</script>
    <script>layout_caption_change('true');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change('preset-1');</script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
