<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title ?? config('app.main') }}</title>
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="{{ $title ?? config('app.main') }}" />
    <meta name="author" content="begawe.com" />
    <meta name="description" content="Sistem Informasi Melayani Dengan Hati" />
    <meta name="keywords" content="begawe.com, laravel" />
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayscrollbars/css/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-icon/css/bootstrap-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/dataTables/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
    @stack('css')

    <script src="{{ asset('assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
</head>


<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
    @include('sweetalert::alert')
    <div class="app-wrapper">
        <main class="app-main pb-0">
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        @include('website.layouts.footer')
