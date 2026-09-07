@extends('layouts.admin')
@section('title', 'Insights CMS | BIC')
@section('admin-content')
<div class="admin-title"><div><p class="eyebrow">Content management</p><h1>Insights</h1></div><a class="admin-primary" href="{{ route('admin.insights.create') }}">New Insight</a></div>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Published</th><th>Featured</th><th></th></tr></thead><tbody>@foreach($insights as $insight)<tr><td>{{ $insight->title }}</td><td>{{ $insight->category }}</td><td><span class="status-pill">{{ $insight->status }}</span></td><td>{{ $insight->published_at?->format('d M Y') ?: '—' }}</td><td>{{ $insight->featured ? 'Yes' : 'No' }}</td><td><a href="{{ route('admin.insights.edit', $insight) }}">Edit</a></td></tr>@endforeach</tbody></table></div>{{ $insights->links() }}
@endsection

