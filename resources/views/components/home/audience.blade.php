@php
$audiences = [
['01','strategic-investment-hd.webp','Startup founder and advisors in a capital discussion','Startups','Traction-led startups seeking growth capital, strategic investors and support beyond the cheque.','startup','For startups →'],
['02','msme-growth-hd.webp','MSME promoters inside a modern operating business','MSMEs','Established MSMEs seeking equity capital for expansion, ownership transition, professionalisation or growth.','msme','For MSMEs →'],
['03','network-hd.webp','Strategic capital network representing investors and counterparties','Investors','HNIs, UHNIs, family offices and corporates seeking prepared, relevant and relationship-sourced opportunities.','investor','For investors →'],
['04','ma-advisory-hd.webp','Business leaders discussing mergers and acquisitions','Strategic partners and acquirers','Corporates, acquirers and strategic partners seeking direct investments, partnerships or acquisition opportunities.','ma','For strategic partners →'],
];
@endphp
<section class="section reveal" id="serve">
    <div class="eyebrow">Who we serve</div>
    <div class="split"><h2 class="big">Different objectives. One place to begin.</h2><p class="copy">Choose the route that reflects where you are today. BIC will assess fit, readiness and the most relevant next conversation.</p></div>
    <div class="audience-grid">
        @foreach($audiences as [$number,$image,$alt,$title,$copy,$routeType,$link])
        <article class="audience"><div class="audience-media"><img src="{{ asset('images/approved/'.$image) }}" alt="{{ $alt }}"></div><div class="audience-body"><strong>{{ $number }}</strong><h3>{{ $title }}</h3><p>{{ $copy }}</p><a href="{{ route('inquiries.create', $routeType) }}">{{ $link }}</a></div></article>
        @endforeach
    </div>
</section>
