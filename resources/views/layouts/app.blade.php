<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bridge India Capital — Oxblood Platinum — Deck Aligned')</title>
    <meta name="description" content="@yield('description', 'Bridge India Capital — strategic investment and M&A platform for startups, MSMEs and investors.')">
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Bridge India Capital — Oxblood Platinum — Deck Aligned')">
    <meta property="og:description" content="@yield('description', 'Bridge India Capital — strategic investment and M&A platform for startups, MSMEs and investors.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('favicon.ico'))">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    @yield('content')
</body>
</html>