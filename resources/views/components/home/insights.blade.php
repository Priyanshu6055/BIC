@props(['insights'])
<section class="insights reveal" id="insights">
    <div class="eyebrow">Insights</div><h2 class="big">Ideas for better capital and transaction decisions.</h2>
    <div class="insights-grid">
        @foreach($insights as $insight)
        <article class="article"><a href="{{ route('insights.show', $insight->slug) }}"><div class="thumb"><img src="{{ asset($insight->cover_image) }}" alt="{{ $insight->alt_text }}"></div><h3>{{ $insight->title }}</h3><p>{{ $insight->summary }}</p></a></article>
        @endforeach
    </div>
</section>

