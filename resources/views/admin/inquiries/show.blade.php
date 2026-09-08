@extends('layouts.admin')
@section('title', $inquiry->reference.' | BIC Admin')
@section('admin-content')
<div class="admin-detail-header">
    <div class="admin-detail-title">
        <a href="{{ route('admin.inquiries.index') }}" class="admin-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Inquiries
        </a>
        <div class="admin-detail-meta">
            <p class="eyebrow">{{ strtoupper($inquiry->type) }} INQUIRY</p>
            <h1>{{ $inquiry->reference }}</h1>
            <p class="admin-subtext">Received on {{ $inquiry->created_at->format('d M Y \a\t H:i') }}</p>
        </div>
    </div>
    <form method="post" action="{{ route('admin.inquiries.update', $inquiry) }}" class="admin-status-update-form">
        @csrf
        @method('PATCH')
        <div class="admin-select-wrapper">
            <label for="statusSelect">Update Status</label>
            <select id="statusSelect" name="status">
                @foreach(['New','Reviewed','Contacted','Closed','Spam'] as $status)
                    <option @selected($inquiry->status===$status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="admin-primary">Update</button>
    </form>
</div>

<div class="admin-detail">
    <section class="admin-card">
        <div class="admin-card-header">
            <h2>Contact Information</h2>
        </div>
        <dl>
            <dt>Client Name</dt>
            <dd>{{ $inquiry->name }}</dd>
            <dt>Email Address</dt>
            <dd><a href="mailto:{{ $inquiry->email }}" class="table-link">{{ $inquiry->email }}</a></dd>
            <dt>Phone Number</dt>
            <dd>{{ $inquiry->phone ?: '—' }}</dd>
            <dt>Company Name</dt>
            <dd>{{ $inquiry->company ?: '—' }}</dd>
            <dt>Current Status</dt>
            <dd><span class="status-pill status-{{ $inquiry->status }}"><span class="status-dot"></span>{{ $inquiry->status }}</span></dd>
        </dl>
    </section>

    <section class="admin-card">
        <div class="admin-card-header">
            <h2>Submission Details</h2>
        </div>
        <dl>
            @forelse($inquiry->payload as $key => $value)
                <dt>{{ str($key)->headline() }}</dt>
                <dd>{{ is_bool($value) ? ($value ? 'Yes' : 'No') : (is_array($value) ? implode(', ', $value) : ($value ?: '—')) }}</dd>
            @empty
                <dt>Data</dt>
                <dd>No additional questionnaire fields submitted.</dd>
            @endforelse
        </dl>
    </section>

    @if($inquiry->document_path)
    <section class="admin-card full-span">
        <div class="admin-card-header">
            <h2>Attached Document</h2>
        </div>
        <div style="padding: 8px 0;">
            <a class="admin-primary" href="{{ route('admin.inquiries.document', $inquiry) }}" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Download Attached PDF Document
            </a>
        </div>
    </section>
    @endif
</div>
@endsection
