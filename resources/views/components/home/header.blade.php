<header class="site-header">
    <a class="brand" href="{{ route('home') }}">BIC<small>BRIDGE INDIA CAPITAL</small></a>
    <nav aria-label="Primary">
        <a href="{{ route('home') }}#about-bic">About BIC</a><a href="{{ route('home') }}#what">What we do</a><a href="{{ route('home') }}#serve">Who we serve</a>
        <a href="{{ route('home') }}#why">Why BIC</a><a href="{{ route('insights.index') }}" @if(request()->routeIs('insights.*')) class="active" aria-current="page" @endif>Insights</a><a href="{{ route('inquiries.create', 'contact') }}">Contact</a>
    </nav>
    <a class="header-cta" href="{{ route('inquiries.create', 'contact') }}">Start a conversation</a>
</header>

