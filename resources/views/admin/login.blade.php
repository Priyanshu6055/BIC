@extends('layouts.admin')
@section('title', 'Admin login | Bridge India Capital')
@section('admin-content')
<div class="admin-login"><div><p class="eyebrow">Secure administration</p><h1>Admin login</h1><form method="post" action="{{ route('admin.login.store') }}">@csrf
    <label>Email<input name="email" type="email" value="{{ old('email') }}" required autocomplete="email"></label>@error('email')<p class="admin-error">{{ $message }}</p>@enderror
    <label>Password<input name="password" type="password" required autocomplete="current-password"></label>@error('password')<p class="admin-error">{{ $message }}</p>@enderror
    <label class="admin-check"><input name="remember" type="checkbox" value="1"> Keep me signed in</label><button class="admin-primary" type="submit">Sign in</button>
</form></div></div>
@endsection

