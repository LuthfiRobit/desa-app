<!DOCTYPE html>
<html lang="id">
<head>
    @include('landing.partials.header')
    <title>@yield('title', 'Desa Sukorejo - Portal Desa Digital')</title>
</head>
<body>
    @include('landing.partials.navbar')

    {{-- Render Hero/Slider Section if yielded --}}
    @yield('hero')

    @yield('content')

    @include('landing.partials.footer')
    @include('landing.partials.scripts')
</body>
</html>
