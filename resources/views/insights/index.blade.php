@extends('layouts.app')
@section('title', 'Insights & Research | Bridge India Capital')
@section('description', 'Ideas for better capital and transaction decisions from Bridge India Capital.')

@section('content')
<div class="insights-shell">
    <x-home.header />

    <main class="insights-main">
        <div class="insights-container">
            <div class="insight-nav-bar">
                <a href="{{ route('home') }}" class="insight-back-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Home
                </a>
                <span class="insight-category-badge">BIC Strategy &amp; Research</span>
            </div>

            <header class="insight-article-header" style="margin-bottom: 48px;">
                <p class="eyebrow" style="color: var(--accent); margin-bottom: 12px;">Market Perspectives</p>
                <h1 class="insight-article-title" style="margin-bottom: 16px;">Ideas for better capital and transaction decisions.</h1>
                <p style="font-size: 17px; line-height: 1.6; color: var(--muted); max-width: 680px; margin: 0;">In-depth analyses, advisory frameworks, and market notes on early-stage investments, MSME equity readiness, and Indian M&amp;A dynamics.</p>
            </header>

            <div class="insights-grid" style="margin-top: 0; margin-bottom: 48px;">
                @foreach($insights as $insight)
                <article class="article">
                    <a href="{{ route('insights.show', $insight->slug) }}" style="display: block; text-decoration: none; color: inherit;">
                        @if($insight->cover_image)
                        <div class="thumb" style="border-radius: 6px; overflow: hidden; margin-bottom: 16px; height: 220px;">
                            <img src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text ?: $insight->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        @endif
                        <p class="eyebrow" style="margin-bottom: 8px; font-size: 10px; color: var(--accent); font-weight: 700;">{{ $insight->category }}</p>
                        <h2 style="font-family: Georgia, serif; font-size: 22px; line-height: 1.25; margin: 0 0 10px; color: var(--ink);">{{ $insight->title }}</h2>
                        <p style="font-size: 14px; line-height: 1.6; color: var(--muted); margin: 0;">{{ $insight->summary }}</p>
                    </a>
                </article>
                @endforeach
            </div>

            <div style="margin-top: 36px;">
                {{ $insights->links() }}
            </div>
        </div>
    </main>

    <x-home.footer />
</div>
@endsection
