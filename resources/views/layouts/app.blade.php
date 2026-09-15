<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bridge India Capital — Strategic Capital Infrastructure')</title>
    <meta name="description" content="@yield('description', 'Bridge India Capital — strategic investment and M&A platform for startups, MSMEs and investors.')">
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Bridge India Capital — Strategic Capital Infrastructure')">
    <meta property="og:description" content="@yield('description', 'Bridge India Capital — strategic investment and M&A platform for startups, MSMEs and investors.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('favicon.ico'))">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    @yield('content')

    @if(session('success'))
        <div id="bic-server-flash" data-type="success" data-title="Action Completed Successfully" data-message="{{ session('success') }}" hidden></div>
    @elseif(session('error'))
        <div id="bic-server-flash" data-type="error" data-title="Action Unsuccessful" data-message="{{ session('error') }}" hidden></div>
    @endif
</body>
</html>