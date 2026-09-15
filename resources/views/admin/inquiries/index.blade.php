@extends('layouts.admin')
@section('title', 'Inquiry Dashboard | BIC Administration')
@section('admin-content')
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow">Client Submissions</p>
            <h1>Inquiry Dashboard</h1>
        </div>
        <div class="admin-header-actions">
            <div class="admin-export-group">
                <a href="{{ route('admin.inquiries.export', ['scope' => 'all', 'format' => 'csv']) }}" class="admin-btn-export" title="Download all records from the full database table to Excel (.csv)">
                    <svg class="admin-btn-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Download Full Table (Excel)</span>
                </a>
                @if(request()->anyFilled(['search', 'type', 'status']))
                <a href="{{ route('admin.inquiries.export', array_merge(request()->query(), ['filtered' => 1, 'format' => 'csv'])) }}" class="admin-btn-export-subtle" title="Download only the currently filtered records">
                    <span>Export Filtered</span>
                </a>
                @endif
                <a href="{{ route('admin.inquiries.export', array_merge(request()->query(), ['format' => 'json'])) }}" class="admin-btn-export-subtle" title="Download inquiries in JSON format">
                    <svg class="admin-btn-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                    </svg>
                    <span>JSON</span>
                </a>
            </div>
        </div>
    </div>

    <div class="admin-toolbar">
        <form class="admin-filters" method="GET" action="{{ route('admin.inquiries.index') }}">
            <div class="admin-search-wrap">
                <svg class="admin-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" placeholder="Search reference, name, email, company..." value="{{ request('search') }}">
            </div>
            <select name="type" onchange="this.form.submit()">
                <option value="">All Types</option>
                @foreach(['startup','msme','investor','ma','contact'] as $type)
                    <option value="{{ $type }}" @selected(request('type')===$type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['New','Reviewed','Contacted','Closed','Spam'] as $status)
                    <option value="{{ $status }}" @selected(request('status')===$status)>{{ $status }}</option>
                @endforeach
            </select>
            <button type="submit" class="admin-btn-filter">Filter</button>
            @if(request()->anyFilled(['search', 'type', 'status']))
                <a href="{{ route('admin.inquiries.index') }}" class="admin-btn-clear">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Date</th>
                <th>Type</th>
                <th>Client Name</th>
                <th>Email Address</th>
                <th>Company</th>
                <th>Status</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inquiry)
                <tr>
                    <td><span class="ref-badge">{{ $inquiry->reference }}</span></td>
                    <td class="text-muted-cell">{{ $inquiry->created_at->format('d M Y') }}</td>
                    <td><span class="type-pill">{{ strtoupper($inquiry->type) }}</span></td>
                    <td class="fw-medium">{{ $inquiry->name }}</td>
                    <td><a href="mailto:{{ $inquiry->email }}" class="table-link">{{ $inquiry->email }}</a></td>
                    <td class="text-muted-cell">{{ Str::limit($inquiry->company ?: '—', 28) }}</td>
                    <td><span class="status-pill status-{{ $inquiry->status }}"><span class="status-dot"></span>{{ $inquiry->status }}</span></td>
                    <td style="text-align: right;"><a href="{{ route('admin.inquiries.show', $inquiry) }}" class="admin-btn-table">View Details &rarr;</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="table-empty-cell">
                        <div class="admin-empty-state">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--admin-text-muted); margin-bottom: 12px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <p>No inquiries found matching your current filter criteria.</p>
                            @if(request()->anyFilled(['search', 'type', 'status']))
                                <a href="{{ route('admin.inquiries.index') }}" class="admin-btn-clear" style="margin-top: 8px;">Reset filters</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-pagination-wrap">
    {{ $inquiries->links() }}
</div>
@endsection
