@extends('layouts.app')

@section('content')
<div class="approved-site">
    <a class="skip" href="#main">Skip to content</a>
    <x-home.header />
    <div class="progress" aria-hidden="true"><b></b></div>
    <main id="main">
        <x-home.hero />
        <x-home.about />
        <x-home.evidence />
        <x-home.services />
        <x-home.audience />
        <x-home.capital-plus-one />
        <x-home.process />
        <x-home.trust />
        <x-home.insights :insights="$insights" />
        <x-home.cta />
    </main>
    <x-home.footer />
</div>
@endsection

