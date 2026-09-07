@extends('layouts.app')
@section('title', 'Insights | Bridge India Capital')
@section('description', 'Ideas for better capital and transaction decisions from Bridge India Capital.')
@section('content')
<main class="public-insights"><a class="inquiry-wordmark" href="{{ route('home') }}"><span>BIC</span><small>Bridge India Capital</small></a><header><p class="eyebrow">Insights</p><h1>Ideas for better capital and transaction decisions.</h1></header><div class="insights-grid">@foreach($insights as $insight)<article class="article"><a href="{{ route('insights.show',$insight->slug) }}"><div class="thumb"><img src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text }}"></div><p class="eyebrow">{{ $insight->category }}</p><h2>{{ $insight->title }}</h2><p>{{ $insight->summary }}</p></a></article>@endforeach</div>{{ $insights->links() }}</main>
@endsection

