@extends('layouts.app')
@section('title', $insight->seo_title ?: $insight->title.' | Bridge India Capital')
@section('description', $insight->seo_description ?: $insight->summary)
@section('og_type', 'article')
@section('og_image', asset($insight->cover_image))

@section('content')
<div class="approved-site insights-page-shell insight-detail-shell">
    <x-home.header />

    <main class="insights-main" id="main">
        <div class="insights-container">
            <!-- Breadcrumbs & Meta Bar -->
            <div class="insight-nav-bar">
                <nav class="insight-breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="bc-sep">/</span>
                    <a href="{{ route('insights.index') }}">Insights</a>
                    @if($insight->category)
                    <span class="bc-sep">/</span>
                    <span class="bc-current">{{ $insight->category }}</span>
                    @endif
                </nav>
                <div class="insight-meta-actions">
                    <a href="{{ route('insights.index') }}" class="insight-back-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        All Insights
                    </a>
                </div>
            </div>

            <!-- Article Hero / Header Area -->
            <div class="insight-article-header">
                @if($insight->category)
                <p class="eyebrow insight-header-eyebrow">{{ $insight->category }}</p>
                @endif
                <h1 class="insight-article-title">{{ $insight->title }}</h1>
                @if($insight->summary)
                <p class="insight-article-lead">{{ $insight->summary }}</p>
                @endif

                <div class="insight-author-bar">
                    <div class="insight-author-info">
                        <div class="insight-author-avatar">{{ strtoupper(substr($insight->author ?: 'BIC', 0, 1)) }}</div>
                        <div>
                            <span class="insight-author-name">{{ $insight->author ?: 'Bridge India Capital Research' }}</span>
                            <div class="insight-meta-subtext">
                                @if($insight->published_at)
                                <time datetime="{{ $insight->published_at->toISOString() }}">{{ $insight->published_at->format('F d, Y') }}</time>
                                <span class="dot-sep">·</span>
                                @endif
                                <span>{{ max(1, (int) ceil(str_word_count(strip_tags($insight->body)) / 180)) }} min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="insight-share-wrap">
                        <button type="button" class="insight-share-btn" onclick="navigator.clipboard.writeText(window.location.href); this.setAttribute('data-copied', 'true'); setTimeout(() => this.removeAttribute('data-copied'), 2200)" aria-label="Copy article link">
                            <svg class="share-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                            </svg>
                            <span class="share-label">Share article</span>
                            <span class="copied-label">Copied!</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Featured Cover Image (Clickable for Expanded View) -->
            @if($insight->cover_image)
            <div class="insight-cover-container">
                <figure class="insight-cover-wrap" onclick="document.getElementById('insightLightbox').showModal()" title="Click to view full size image" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){document.getElementById('insightLightbox').showModal();event.preventDefault();}">
                    <img class="insight-cover-img" src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text ?: $insight->title }}">
                    <div class="cover-zoom-badge" aria-hidden="true">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            <line x1="11" y1="8" x2="11" y2="14"/>
                            <line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                        <span>Click for larger view</span>
                    </div>
                </figure>
            </div>

            <!-- Lightbox Dialog for Big View -->
            <dialog class="insight-lightbox" id="insightLightbox" aria-label="Expanded Image View" onclick="if(event.target===this) this.close()">
                <div class="lightbox-content">
                    <button type="button" class="lightbox-close" aria-label="Close expanded view" onclick="this.closest('dialog').close()">&times;</button>
                    <img src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text ?: $insight->title }}" class="lightbox-img">
                    @if($insight->alt_text || $insight->title)
                    <p class="lightbox-caption">{{ $insight->alt_text ?: $insight->title }}</p>
                    @endif
                </div>
            </dialog>
            @endif

            <!-- Article Body Content (Markdown Formatted) -->
            <div class="insight-article-wrapper">
                <article class="insight-article-body">
                    {!! \Illuminate\Support\Str::markdown($insight->body) !!}
                </article>

                <!-- Advisory CTA Card -->
                <div class="insight-advisory-cta">
                    <span class="eyebrow cta-eyebrow">Advisory &amp; Capital Practice</span>
                    <h3>Discuss your capital &amp; transaction readiness</h3>
                    <p>Bridge India Capital connects traction-led startups and established MSMEs with family offices, corporates, and strategic institutional capital. Reach out to evaluate your transaction readiness directly with our advisory desk.</p>
                    <div class="insight-advisory-actions">
                        <a href="{{ route('inquiries.create', 'contact') }}" class="insight-advisory-btn">Start a Conversation &rarr;</a>
                        <a href="{{ route('home') }}#what" class="insight-advisory-secondary">Explore Advisory Scope</a>
                    </div>
                </div>
            </div>

            <!-- Related Insights Section -->
            @if(isset($relatedInsights) && $relatedInsights->isNotEmpty())
            <div class="insight-related-section">
                <div class="related-header">
                    <div>
                        <p class="eyebrow">Further Reading</p>
                        <h2 class="related-title">Related Research &amp; Perspectives</h2>
                    </div>
                    <a href="{{ route('insights.index') }}" class="view-all-link">View all research &rarr;</a>
                </div>
                <div class="insights-grid">
                    @foreach($relatedInsights as $related)
                    <article class="article insight-card">
                        <a href="{{ route('insights.show', $related->slug) }}" class="insight-card-link">
                            @if($related->cover_image)
                            <div class="thumb">
                                <img src="{{ asset($related->cover_image) }}" alt="{{ $related->alt_text ?: $related->title }}" loading="lazy">
                            </div>
                            @endif
                            @if($related->category)
                            <p class="eyebrow card-eyebrow">{{ $related->category }}</p>
                            @endif
                            <h3 class="card-title">{{ $related->title }}</h3>
                            <p class="card-summary">{{ $related->summary }}</p>
                        </a>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="insight-bottom-nav">
                <a href="{{ route('insights.index') }}" class="insight-back-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to All Insights
                </a>
            </div>
        </div>
    </main>

    <x-home.footer />
</div>
@endsection
