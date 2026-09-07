@extends('layouts.admin')
@section('title', $inquiry->reference.' | BIC Admin')
@section('admin-content')
<div class="admin-title"><div><p class="eyebrow">{{ strtoupper($inquiry->type) }} inquiry</p><h1>{{ $inquiry->reference }}</h1><p>Received {{ $inquiry->created_at->format('d M Y, H:i') }}</p></div><form method="post" action="{{ route('admin.inquiries.update', $inquiry) }}">@csrf @method('PATCH')<label>Status<select name="status">@foreach(['New','Reviewed','Contacted','Closed','Spam'] as $status)<option @selected($inquiry->status===$status)>{{ $status }}</option>@endforeach</select></label><button class="admin-primary">Update</button></form></div>
<div class="admin-detail"><section><h2>Contact</h2><dl><dt>Name</dt><dd>{{ $inquiry->name }}</dd><dt>Email</dt><dd>{{ $inquiry->email }}</dd><dt>Phone</dt><dd>{{ $inquiry->phone }}</dd><dt>Company</dt><dd>{{ $inquiry->company ?: '—' }}</dd></dl></section><section><h2>Submitted fields</h2><dl>@foreach($inquiry->payload as $key=>$value)<dt>{{ str($key)->headline() }}</dt><dd>{{ is_bool($value) ? ($value ? 'Yes' : 'No') : $value }}</dd>@endforeach</dl></section>@if($inquiry->document_path)<section><h2>Private document</h2><a class="admin-primary" href="{{ route('admin.inquiries.document', $inquiry) }}">Download PDF</a></section>@endif</div>
@endsection

