@extends('layouts.app')
@section('title', $insight->seo_title ?: $insight->title.' | Bridge India Capital')
@section('description', $insight->seo_description ?: $insight->summary)
@section('og_type', 'article')
@section('og_image', asset($insight->cover_image))
@section('content')
<main class="insight-detail"><a class="inquiry-wordmark" href="{{ route('home') }}"><span>BIC</span><small>Bridge India Capital</small></a><article><p class="eyebrow">{{ $insight->category }}</p><h1>{{ $insight->title }}</h1><p class="insight-summary">{{ $insight->summary }}</p>@if($insight->cover_image)<img src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text }}">@endif<div class="insight-body">{!! nl2br(e($insight->body)) !!}</div><footer>{{ $insight->author }} · {{ $insight->published_at?->format('d M Y') }}</footer></article></main>
@endsection
