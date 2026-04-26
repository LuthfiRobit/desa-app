<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Desa Sukorejo - Kecamatan Kotaanyar, Kabupaten Probolinggo')</title>
    <meta name="description" content="@yield('meta_description', 'Portal resmi Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo. Temukan informasi pelayanan, berita desa, transparansi APBDes, dan profil desa.')">
    <meta name="keywords" content="@yield('meta_keywords', 'desa sukorejo, kotaanyar, probolinggo, portal desa sukorejo, sukorejo kotaanyar, website desa sukorejo')">
    <meta name="author" content="Pemerintah Desa Sukorejo">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Desa Sukorejo - Portal Desa Digital')">
    <meta property="og:description" content="@yield('meta_description', 'Portal resmi Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo.')">
    <meta property="og:image" content="@yield('og_image', asset('template/assets/img/og-image.jpg'))">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Desa Sukorejo - Portal Desa Digital')">
    <meta property="twitter:description" content="@yield('meta_description', 'Portal resmi Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo.')">
    <meta property="twitter:image" content="@yield('og_image', asset('template/assets/img/og-image.jpg'))">

    <link rel="canonical" href="{{ url()->current() }}">

    @include('landing.partials.header')
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
