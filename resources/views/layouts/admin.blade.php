@extends('layouts.app')

@section('robots', 'noindex,nofollow')

@section('content')
<div class="admin-shell">
    <header class="admin-header"><a href="{{ route('admin.inquiries.index') }}"><strong>BIC</strong><span>Administration</span></a>@auth<nav><a href="{{ route('admin.inquiries.index') }}">Inquiries</a><a href="{{ route('admin.insights.index') }}">Insights</a><form action="{{ route('admin.logout') }}" method="post">@csrf<button type="submit">Log out</button></form></nav>@endauth</header>
    <main class="admin-main">@if(session('success'))<div class="admin-notice">{{ session('success') }}</div>@endif @yield('admin-content')</main>
</div>
@endsection

