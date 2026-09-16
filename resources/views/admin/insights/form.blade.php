@extends('layouts.admin')
@section('title', ($insight->exists ? 'Edit' : 'Create').' Insight | BIC Admin')
@section('admin-content')
<div class="admin-detail-header">
    <div class="admin-detail-title">
        <a href="{{ route('admin.insights.index') }}" class="admin-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Insights
        </a>
        <div class="admin-detail-meta">
            <p class="eyebrow">Content Management</p>
            <h1>{{ $insight->exists ? 'Edit Insight' : 'Create New Insight' }}</h1>
        </div>
    </div>
    @if($insight->exists)
        <div class="admin-detail-actions">
            <button type="button" class="admin-btn-danger-fill" onclick="if(confirm('Are you sure you want to delete this insight: &quot;{{ addslashes($insight->title) }}&quot;? This action cannot be undone.')) { document.getElementById('deleteInsightForm').submit(); }">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                <span>Delete Insight</span>
            </button>
        </div>
    @endif
</div>

<form class="admin-form-card" method="post" enctype="multipart/form-data" action="{{ $insight->exists ? route('admin.insights.update', $insight) : route('admin.insights.store') }}">
    @csrf
    @if($insight->exists)
        @method('PUT')
    @endif

    <div class="admin-form-grid">
        <label class="wide">
            <span>Title <strong class="req">*</strong></span>
            <input name="title" value="{{ old('title', $insight->title) }}" required placeholder="e.g. Navigating Indian Seed-Stage Valuation Trends">
        </label>
        
        <label class="wide">
            <span>Slug (URL Segment)</span>
            <input name="slug" value="{{ old('slug', $insight->slug) }}" placeholder="Generated from title automatically if empty">
        </label>
        
        <label class="wide">
            <span>Summary / Excerpt <strong class="req">*</strong></span>
            <textarea name="summary" rows="3" required placeholder="Brief excerpt summarizing key findings...">{{ old('summary', $insight->summary) }}</textarea>
        </label>
        
        <label class="wide">
            <span>Full Article Body (Markdown supported) <strong class="req">*</strong></span>
            <textarea name="body" rows="14" required placeholder="Write the complete article content...">{{ old('body', $insight->body) }}</textarea>
        </label>
        
        <label>
            <span>Cover Image File <small style="font-weight: normal; color: var(--admin-text-muted); font-size: 11.5px;">(Recommended: 1200 &times; 675 px &bull; 16:9 ratio &bull; Max 5 MB)</small></span>
            <input name="cover_upload" type="file" accept="image/png,image/jpeg,image/webp,image/jpg">
            <small class="admin-input-hint" style="display: block; margin-top: 5px;">
                Recommended size: <strong>1200 &times; 675 px</strong> (landscape 16:9 ratio). Max file size: <strong>5 MB</strong> (JPG, PNG, WebP).
            </small>
            @if($insight->cover_image)
                <small class="admin-input-hint" style="display: block; margin-top: 4px; color: var(--admin-primary);">
                    Current image: <a href="{{ asset($insight->cover_image) }}" target="_blank" style="color: inherit; text-decoration: underline;">{{ $insight->cover_image }}</a>
                </small>
            @endif
        </label>
        
        <label>
            <span>Image Alt Text</span>
            <input name="alt_text" value="{{ old('alt_text', $insight->alt_text) }}" placeholder="Image description for accessibility">
        </label>
        
        <label>
            <span>Author</span>
            <input name="author" value="{{ old('author', $insight->author) }}" placeholder="e.g. BIC Investment Committee">
        </label>
        
        <label>
            <span>Category</span>
            <input name="category" value="{{ old('category', $insight->category) }}" placeholder="e.g. Venture Capital, M&A Advisory">
        </label>
        
        <label>
            <span>Publication Status</span>
            <select name="status">
                @foreach(['draft','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $insight->status ?: 'draft')===$status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </label>
        
        <label>
            <span>Publish Date & Time</span>
            <input name="published_at" type="datetime-local" value="{{ old('published_at', $insight->published_at?->format('Y-m-d\TH:i')) }}">
        </label>
        
        <div class="wide admin-check-wrap">
            <label class="admin-check">
                <input name="featured" type="checkbox" value="1" @checked(old('featured', $insight->featured))>
                <span>Feature this insight on BIC homepage & featured hero carousel</span>
            </label>
        </div>
        
        <div class="wide" style="border-top: 1px solid var(--admin-border); padding-top: 24px; margin-top: 12px;">
            <h3 style="font-size: 16px; margin: 0 0 16px; font-weight: 600; color: var(--admin-text-main);">Search Engine Optimization (SEO)</h3>
        </div>

        <label class="wide">
            <span>SEO Meta Title</span>
            <input name="seo_title" value="{{ old('seo_title', $insight->seo_title) }}" placeholder="Custom meta title for Google (optional)">
        </label>
        
        <label class="wide">
            <span>SEO Meta Description</span>
            <textarea name="seo_description" rows="2" placeholder="Custom meta description for search engine previews (optional)">{{ old('seo_description', $insight->seo_description) }}</textarea>
        </label>
    </div>

    @if($errors->any())
        <div class="admin-error-box">
            <strong>Please correct the form errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-form-actions" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; gap: 12px; align-items: center;">
            <button class="admin-primary" type="submit">Save Insight</button>
            <a href="{{ route('admin.insights.index') }}" class="admin-btn-clear">Cancel</a>
        </div>
        @if($insight->exists)
            <button type="button" class="admin-btn-danger-outline" onclick="if(confirm('Are you sure you want to delete this insight: &quot;{{ addslashes($insight->title) }}&quot;? This action cannot be undone.')) { document.getElementById('deleteInsightForm').submit(); }">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                <span>Delete Insight</span>
            </button>
        @endif
    </div>
</form>

@if($insight->exists)
    <form id="deleteInsightForm" method="POST" action="{{ route('admin.insights.destroy', $insight) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endif
@endsection
