@extends('layouts.admin')
@section('title', 'Inquiry dashboard | BIC')
@section('admin-content')
<div class="admin-title"><div><p class="eyebrow">Inquiry operations</p><h1>Inquiry dashboard</h1></div><form class="admin-filters"><select name="type"><option value="">All types</option>@foreach(['startup','msme','investor','ma','contact'] as $type)<option @selected(request('type')===$type)>{{ $type }}</option>@endforeach</select><select name="status"><option value="">All statuses</option>@foreach(['New','Reviewed','Contacted','Closed','Spam'] as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select><button>Filter</button></form></div>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Reference</th><th>Date</th><th>Type</th><th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($inquiries as $inquiry)<tr><td><code>{{ $inquiry->reference }}</code></td><td>{{ $inquiry->created_at->format('d M Y') }}</td><td>{{ strtoupper($inquiry->type) }}</td><td>{{ $inquiry->name }}</td><td>{{ $inquiry->email }}</td><td>{{ $inquiry->phone }}</td><td>{{ $inquiry->company ?: '—' }}</td><td><span class="status-pill">{{ $inquiry->status }}</span></td><td><a href="{{ route('admin.inquiries.show', $inquiry) }}">View</a></td></tr>@empty<tr><td colspan="9">No inquiries found.</td></tr>@endforelse
</tbody></table></div>{{ $inquiries->links() }}
@endsection

