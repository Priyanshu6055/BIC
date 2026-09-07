@extends('layouts.app')

@section('robots', 'noindex,nofollow')

@section('content')
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="{{ route('admin.inquiries.index') }}" class="admin-sidebar-brand">
            <strong>BIC</strong>
            <span>Administration</span>
        </a>
        @auth
        <nav class="admin-sidebar-nav">
            <a href="{{ route('admin.inquiries.index') }}" class="{{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">Inquiries</a>
            <a href="{{ route('admin.insights.index') }}" class="{{ request()->routeIs('admin.insights.*') ? 'active' : '' }}">Insights</a>
            <form action="{{ route('admin.logout') }}" method="post" style="margin-top: auto;">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </nav>
        @endauth
    </aside>
    <main class="admin-main">
        @if(session('success'))
            <div class="admin-notice">{{ session('success') }}</div>
        @endif 
        @yield('admin-content')
    </main>
</div>
@endsection
