@extends('layouts.admin')
@section('title', 'Change Password | BIC Administration')
@section('admin-content')
<div class="admin-detail-header">
    <div class="admin-detail-title">
        <a href="{{ route('admin.inquiries.index') }}" class="admin-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Dashboard
        </a>
        <div class="admin-detail-meta">
            <p class="eyebrow">Security & Credentials</p>
            <h1>Change Administrator Password</h1>
        </div>
    </div>
</div>

<div style="max-width: 680px;">
    @if(session('success'))
        <div class="admin-alert admin-alert-success" role="alert" style="margin-bottom: 24px; padding: 16px 20px; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px; color: #166534; display: flex; align-items: flex-start; gap: 12px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <div>
                <strong style="display: block; font-size: 14px; font-weight: 600;">Password Updated</strong>
                <span style="font-size: 13px;">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="admin-alert admin-alert-error" role="alert" style="margin-bottom: 24px; padding: 16px 20px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; color: #991b1b;">
            <strong style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Unable to update password:</strong>
            <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="admin-form-card" method="post" action="{{ route('admin.password.update') }}">
        @csrf
        @method('PUT')

        <div class="admin-form-grid" style="grid-template-columns: 1fr;">
            <label class="wide">
                <span>Current Password <strong class="req">*</strong></span>
                <input type="password" name="current_password" required autocomplete="current-password" placeholder="Enter your current password">
            </label>

            <label class="wide">
                <span>New Password <strong class="req">*</strong></span>
                <input type="password" name="password" required autocomplete="new-password" minlength="8" placeholder="At least 8 characters">
                <small style="display: block; margin-top: 6px; color: var(--admin-text-muted, #64748b); font-size: 12px;">Ensure your password uses a combination of uppercase letters, numbers, and symbols.</small>
            </label>

            <label class="wide">
                <span>Confirm New Password <strong class="req">*</strong></span>
                <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter the new password">
            </label>
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="admin-primary admin-btn-save">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                Update Password
            </button>
            <a href="{{ route('admin.inquiries.index') }}" class="admin-btn-clear admin-btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
