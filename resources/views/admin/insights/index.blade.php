@extends('layouts.admin')
@section('title', 'Insights CMS | BIC')
@section('admin-content')
<div class="admin-title">
    <div>
        <p class="eyebrow">Content management</p>
        <h1>Insights</h1>
    </div>
    <div style="display: flex; gap: 16px; align-items: center;">
        <form class="admin-filters" method="GET" action="{{ route('admin.insights.index') }}">
            <input type="text" name="search" placeholder="Search insights..." value="{{ request('search') }}">
            <select name="status">
                <option value="">All statuses</option>
                @foreach(['draft','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit">Filter</button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.insights.index') }}" style="font-size: 14px; color: var(--text-muted); text-decoration: none; margin-left: 8px;">Clear</a>
            @endif
        </form>
        <a class="admin-primary" href="{{ route('admin.insights.create') }}">New Insight</a>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Published</th>
                <th>Featured</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($insights as $insight)
                <tr>
                    <td>{{ Str::limit($insight->title, 50) }}</td>
                    <td>{{ $insight->category ?: '—' }}</td>
                    <td><span class="status-pill status-{{ ucfirst($insight->status) }}">{{ ucfirst($insight->status) }}</span></td>
                    <td>{{ $insight->published_at?->format('d M Y') ?: '—' }}</td>
                    <td>{{ $insight->featured ? 'Yes' : 'No' }}</td>
                    <td><a href="{{ route('admin.insights.edit', $insight) }}">Edit</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 48px; color: var(--text-muted);">No insights found matching your criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 24px;">
    {{ $insights->links() }}
</div>
@endsection
