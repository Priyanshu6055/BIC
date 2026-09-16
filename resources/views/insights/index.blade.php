@extends('layouts.app')
@section('title', 'Insights & Research | Bridge India Capital')
@section('description', 'Ideas for better capital and transaction decisions from Bridge India Capital.')

@section('content')
<div class="approved-site insights-page-shell">
    <x-home.header />

    <main class="insights-main" id="main">
        <div class="insights-container">
            <div class="insights-hero-header">
                <p class="eyebrow">Market Perspectives &amp; Research</p>
                <h1 class="insights-hero-title">Ideas for better capital and transaction decisions.</h1>
                <p class="insights-hero-lead">In-depth analyses, advisory frameworks, and market notes on early-stage investments, MSME equity readiness, and Indian M&amp;A dynamics.</p>
            </div>

            <div class="insights-grid">
                @forelse($insights as $insight)
                <article class="article insight-card">
                    <a href="{{ route('insights.show', $insight->slug) }}" class="insight-card-link">
                        @if($insight->cover_image)
                        <div class="thumb">
                            <img src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text ?: $insight->title }}" loading="lazy">
                        </div>
                        @endif
                        @if($insight->category)
                        <p class="eyebrow card-eyebrow">{{ $insight->category }}</p>
                        @endif
                        <h2 class="card-title">{{ $insight->title }}</h2>
                        <p class="card-summary">{{ $insight->summary }}</p>
                    </a>
                </article>
                @empty
                <div class="insights-empty-state">
                    <p>No insights published yet. Please check back shortly.</p>
                </div>
                @endforelse
            </div>

            @if($insights->hasPages())
            <div class="insights-pagination-wrap">
                {{ $insights->links() }}
            </div>
            @endif
        </div>
    </main>

    <x-home.footer />
</div>
@endsection
