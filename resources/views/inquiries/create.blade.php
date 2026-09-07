@extends('layouts.app')

@section('title', $config['title'].' | Bridge India Capital')
@section('description', $config['purpose'])
@section('robots', 'noindex,nofollow')

@section('content')
<main class="inquiry-page" id="main">
    <div class="inquiry-container">
        <a class="inquiry-wordmark" href="{{ route('home') }}" aria-label="Bridge India Capital home"><span>BIC</span><small>Bridge India Capital</small></a>
        <div class="inquiry-intro">
            <p class="eyebrow">Initial inquiry · {{ $type === 'ma' ? 'M&A' : strtoupper($type) }}</p>
            <h1>{{ $config['title'] }}</h1><p>{{ $config['purpose'] }}</p>
            <p class="inquiry-privacy-note">Please provide only the requested initial information. Do not submit identity documents, bank statements, full financial statements, complete cap tables or confidential customer lists.</p>
        </div>
        @if(session('submission'))
            <div class="inquiry-result"><div class="state-panel state-panel--success"><h2>Inquiry received</h2><p>{{ session('submission.message') }}</p><p><strong>Reference:</strong> <span class="reference-code">{{ session('submission.reference') }}</span></p></div></div>
        @else
        <form class="inquiry-form" action="{{ route('inquiries.store', $type) }}" method="post" enctype="multipart/form-data" novalidate data-inquiry-form>
            @csrf
            <div class="inquiry-mode" data-mode="live" role="status"><strong>Service status</strong><span>Secure production inquiry service. Required fields are marked with an asterisk.</span></div>
            <nav class="form-progress" aria-label="Form progress"><ol>
                @foreach($config['steps'] as $step)
                <li data-current="{{ $loop->first ? 'true' : 'false' }}"><button type="button" data-step-button="{{ $loop->index }}" @disabled(!$loop->first) aria-current="{{ $loop->first ? 'step' : 'false' }}"><span>{{ $loop->iteration }}</span><span class="form-progress-label">{{ $step['title'] }}</span></button></li>
                @endforeach
            </ol></nav>
            <div class="form-error-summary" role="alert" tabindex="-1" hidden><strong>Review this step</strong><span>Correct the highlighted fields before continuing.</span></div>
            <div class="submission-state" role="status" hidden></div>
            @foreach($config['steps'] as $step)
            <fieldset class="inquiry-step" data-step="{{ $loop->index }}" @if(!$loop->first) hidden @endif>
                <legend>{{ $step['title'] }}</legend><p class="inquiry-step-description">{{ $step['description'] }}</p>
                <div class="inquiry-fields">
                @foreach($step['fields'] as $field)
                    @php($id = 'inquiry-'.$field['name'])
                    @if($field['type'] === 'checkbox')
                    <div class="inquiry-checkbox-field" data-field="{{ $field['name'] }}"><label class="checkbox"><input class="checkbox__control" id="{{ $id }}" name="{{ $field['name'] }}" type="checkbox" value="1" @checked(old($field['name'])) @if($field['required']) required @endif><span>{{ $field['label'] }}@if($field['required']) <span aria-hidden="true">*</span>@endif</span></label><p class="field__error" id="{{ $id }}-error" role="alert" hidden></p></div>
                    @else
                    <div class="field" data-field="{{ $field['name'] }}">
                        <label class="field__label" for="{{ $id }}">{{ $field['label'] }}@if($field['required']) <span aria-hidden="true">*</span>@endif</label>
                        @if(isset($field['hint']))<p class="field__hint" id="{{ $id }}-hint">{{ $field['hint'] }}</p>@endif
                        @if($field['type'] === 'select')
                        <select class="control" id="{{ $id }}" name="{{ $field['name'] }}" @if($field['required']) required @endif><option value="">Select an option</option>@foreach($field['options'] as $option)<option value="{{ $option['value'] }}" @selected(old($field['name']) === $option['value'])>{{ $option['label'] }}</option>@endforeach</select>
                        @elseif($field['type'] === 'textarea')
                        <textarea class="control control--textarea" id="{{ $id }}" name="{{ $field['name'] }}" maxlength="1200" @if($field['required']) required @endif>{{ old($field['name']) }}</textarea>
                        @elseif($field['type'] === 'file')
                        <input class="control" id="{{ $id }}" name="{{ $field['name'] }}" type="file" accept="application/pdf,.pdf">
                        @else
                        <input class="control" id="{{ $id }}" name="{{ $field['name'] }}" type="{{ $field['type'] }}" value="{{ old($field['name']) }}" maxlength="254" @if(isset($field['autoComplete'])) autocomplete="{{ $field['autoComplete'] }}" @endif @if($field['required']) required @endif>
                        @endif
                        <p class="field__error" id="{{ $id }}-error" role="alert" hidden></p>
                    </div>
                    @endif
                @endforeach
                </div>
            </fieldset>
            @endforeach
            <div class="inquiry-actions"><button class="button button--quiet" type="button" data-back hidden>Back</button><button class="button button--primary" type="button" data-next>Continue</button><button class="button button--primary" type="submit" data-submit hidden>Submit inquiry</button></div>
            <div class="honeypot" aria-hidden="true"><label for="companyFax">Company fax</label><input id="companyFax" name="companyFax" tabindex="-1" autocomplete="off"></div>
        </form>
        @endif
    </div>
</main>
@endsection

