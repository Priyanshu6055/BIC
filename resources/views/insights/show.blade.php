@extends('layouts.app')
@section('title', $insight->seo_title ?: $insight->title.' | Bridge India Capital')
@section('description', $insight->seo_description ?: $insight->summary)
@section('og_type', 'article')
@section('og_image', asset($insight->cover_image))

@section('content')
<div class="insights-shell">
    <x-home.header />

    <main class="insights-main">
        <div class="insights-container">
            <!-- Top Navigation & Category -->
            <div class="insight-nav-bar">
                <a href="{{ route('insights.index') }}" class="insight-back-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Insights
                </a>
                @if($insight->category)
                    <span class="insight-category-badge">{{ $insight->category }}</span>
                @endif
            </div>

            <!-- Article Header -->
            <header class="insight-article-header">
                <h1 class="insight-article-title">{{ $insight->title }}</h1>
                @if($insight->summary)
                    <p class="insight-article-lead">{{ $insight->summary }}</p>
                @endif

                <div class="insight-author-bar">
                    <div class="insight-author-avatar">{{ strtoupper(substr($insight->author ?: 'BIC', 0, 1)) }}</div>
                    <div>
                        <span class="insight-author-name">{{ $insight->author ?: 'Bridge India Capital Research' }}</span>
                        @if($insight->published_at)
                            <span style="margin-left: 8px; color: #94a3b8;">·</span>
                            <time datetime="{{ $insight->published_at->toISOString() }}" style="margin-left: 8px;">{{ $insight->published_at->format('F d, Y') }}</time>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Featured Cover Image -->
            @if($insight->cover_image)
            <figure class="insight-cover-wrap">
                <img class="insight-cover-img" src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text ?: $insight->title }}">
            </figure>
            @endif

            <!-- Article Body -->
            <article class="insight-article-body">
                {!! nl2br(e($insight->body)) !!}
            </article>

            <!-- Advisory CTA Card -->
            <div class="insight-advisory-cta">
                <h3>Discuss your capital &amp; transaction readiness</h3>
                <p>Bridge India Capital connects traction-led startups and established MSMEs with family offices, corporates, and strategic institutional capital. Reach out to evaluate your transaction readiness with our advisory desk.</p>
                <a href="{{ route('inquiries.create', 'contact') }}" class="insight-advisory-btn">Start a Conversation &rarr;</a>
            </div>
        </div>
    </main>

    <x-home.footer />
</div>
@endsection
