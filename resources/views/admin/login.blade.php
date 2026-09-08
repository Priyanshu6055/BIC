@extends('layouts.admin')
@section('title', 'Admin Login | Bridge India Capital')
@section('admin-content')
<div class="admin-login-wrapper">
    <div class="admin-login-card">
        <div class="admin-login-header">
            <div class="admin-brand-mark admin-login-logo">BIC</div>
            <p class="eyebrow">Secure Portal</p>
            <h1>Admin Login</h1>
            <p class="admin-login-sub">Bridge India Capital Administration</p>
        </div>

        <form method="post" action="{{ route('admin.login.store') }}" class="admin-login-form">
            @csrf
            <label>
                <span>Email Address</span>
                <input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="admin@bridgeindiacapital.com" autofocus>
            </label>
            @error('email')
                <p class="admin-error">{{ $message }}</p>
            @enderror

            <label>
                <span>Password</span>
                <input name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
            </label>
            @error('password')
                <p class="admin-error">{{ $message }}</p>
            @enderror

            <div class="admin-login-options">
                <label class="admin-check">
                    <input name="remember" type="checkbox" value="1">
                    <span>Keep me signed in</span>
                </label>
            </div>

            <button class="admin-primary admin-btn-block" type="submit">Sign In to Dashboard</button>
        </form>
    </div>
</div>
@endsection
