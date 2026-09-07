@extends('layouts.admin')
@section('title', 'Inquiry dashboard | BIC')
@section('admin-content')
<div class="admin-title">
    <div>
        <p class="eyebrow">Inquiry operations</p>
        <h1>Inquiry dashboard</h1>
    </div>
    <form class="admin-filters" method="GET" action="{{ route('admin.inquiries.index') }}">
        <input type="text" name="search" placeholder="Search inquiries..." value="{{ request('search') }}">
        <select name="type">
            <option value="">All types</option>
            @foreach(['startup','msme','investor','ma','contact'] as $type)
                <option value="{{ $type }}" @selected(request('type')===$type)>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
        <select name="status">
            <option value="">All statuses</option>
            @foreach(['New','Reviewed','Contacted','Closed','Spam'] as $status)
                <option value="{{ $status }}" @selected(request('status')===$status)>{{ $status }}</option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
        @if(request()->anyFilled(['search', 'type', 'status']))
            <a href="{{ route('admin.inquiries.index') }}" style="font-size: 14px; color: var(--text-muted); text-decoration: none; margin-left: 8px;">Clear</a>
        @endif
    </form>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Date</th>
                <th>Type</th>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inquiry)
                <tr>
                    <td><code>{{ $inquiry->reference }}</code></td>
                    <td>{{ $inquiry->created_at->format('d M Y') }}</td>
                    <td>{{ strtoupper($inquiry->type) }}</td>
                    <td>{{ $inquiry->name }}</td>
                    <td>{{ $inquiry->email }}</td>
                    <td>{{ Str::limit($inquiry->company ?: '—', 30) }}</td>
                    <td><span class="status-pill status-{{ $inquiry->status }}">{{ $inquiry->status }}</span></td>
                    <td><a href="{{ route('admin.inquiries.show', $inquiry) }}">View Details</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 48px; color: var(--text-muted);">No inquiries found matching your criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 24px;">
    {{ $inquiries->links() }}
</div>
@endsection
