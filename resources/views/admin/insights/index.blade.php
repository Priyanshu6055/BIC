@extends('layouts.admin')
@section('title', 'Insights CMS | BIC Administration')
@section('admin-content')
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow">Content Management</p>
            <h1>Insights CMS</h1>
        </div>
        <div class="admin-header-actions">
            <div class="admin-export-group">
                <a href="{{ route('admin.insights.export', array_merge(request()->query(), ['format' => 'csv'])) }}" class="admin-btn-export" title="Download filtered insights to Excel (.csv)">
                    <svg class="admin-btn-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Download Excel</span>
                </a>
                <a href="{{ route('admin.insights.export', array_merge(request()->query(), ['format' => 'json'])) }}" class="admin-btn-export-subtle" title="Download insights in JSON format">
                    <svg class="admin-btn-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                    </svg>
                    <span>JSON</span>
                </a>
            </div>

            <a class="admin-primary admin-btn-create" href="{{ route('admin.insights.create') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>New Insight</span>
            </a>
        </div>
    </div>

    <div class="admin-toolbar">
        <form class="admin-filters" method="GET" action="{{ route('admin.insights.index') }}">
            <div class="admin-search-wrap">
                <svg class="admin-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" placeholder="Search title, author, category..." value="{{ request('search') }}">
            </div>
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" @selected(request('category')===$category)>{{ $category }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['draft','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="admin-btn-filter">Filter</button>
            @if(request()->anyFilled(['search', 'category', 'status']))
                <a href="{{ route('admin.insights.index') }}" class="admin-btn-clear">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Published Date</th>
                <th>Featured</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($insights as $insight)
                <tr>
                    <td class="fw-medium">
                        <a href="{{ route('admin.insights.edit', $insight) }}" class="admin-table-title-link">
                            {{ Str::limit($insight->title, 50) }}
                        </a>
                    </td>
                    <td class="text-muted-cell">{{ $insight->category ?: '—' }}</td>
                    <td><span class="status-pill status-{{ ucfirst($insight->status) }}"><span class="status-dot"></span>{{ ucfirst($insight->status) }}</span></td>
                    <td class="text-muted-cell">{{ $insight->published_at?->format('d M Y') ?: '—' }}</td>
                    <td>
                        @if($insight->featured)
                            <span class="badge-featured">Featured</span>
                        @else
                            <span class="text-muted-cell">No</span>
                        @endif
                    </td>
                    <td style="text-align: right;"><a href="{{ route('admin.insights.edit', $insight) }}" class="admin-btn-table">Edit &rarr;</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="table-empty-cell">
                        <div class="admin-empty-state">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--admin-text-muted); margin-bottom: 12px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <p>No insights found matching your current filter criteria.</p>
                            @if(request()->anyFilled(['search', 'category', 'status']))
                                <a href="{{ route('admin.insights.index') }}" class="admin-btn-clear" style="margin-top: 8px;">Reset filters</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-pagination-wrap">
    {{ $insights->links() }}
</div>
@endsection
