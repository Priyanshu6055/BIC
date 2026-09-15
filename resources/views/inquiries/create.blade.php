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
            <div class="inquiry-result">
                <div class="state-panel state-panel--success" style="text-align: center; padding: 48px 32px;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(34, 197, 94, 0.12); color: #16a34a; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h2 style="font-size: 26px; font-family: Georgia, serif; color: #1e293b; margin: 0 0 24px;">Your response has been submitted successfully.</h2>
                    <p><a class="button button--primary" href="{{ route('home') }}">Back to Home</a></p>
                </div>
            </div>
        @else
        <form class="inquiry-form" action="{{ route('inquiries.store', $type) }}" method="post" enctype="multipart/form-data" novalidate data-inquiry-form>
            @csrf
            <nav class="form-progress" aria-label="Form progress"><ol>
                @foreach($config['steps'] as $step)
                <li data-current="{{ $loop->first ? 'true' : 'false' }}"><button type="button" data-step-button="{{ $loop->index }}" @disabled(!$loop->first) aria-current="{{ $loop->first ? 'step' : 'false' }}"><span>{{ $loop->iteration }}</span><span class="form-progress-label">{{ $step['title'] }}</span></button></li>
                @endforeach
            </ol></nav>
            <div class="form-error-summary" role="alert" tabindex="-1" hidden><strong>Review this step</strong><span>Correct the highlighted fields before continuing.</span></div>
            <div class="submission-state" role="status" hidden></div>
            @foreach($config['steps'] as $step)
            <fieldset class="inquiry-step" data-step="{{ $loop->index }}" @if(!$loop->first) hidden @endif>
                <legend>{{ $step['title'] }}</legend>
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
            <div class="inquiry-actions">
                <a class="button button--quiet" href="{{ route('home') }}" data-home-back>Back</a>
                <button class="button button--quiet" type="button" data-back hidden>Back</button>
                <button class="button button--primary" type="button" data-next>Continue</button>
                <button class="button button--primary" type="submit" data-submit hidden>Submit inquiry</button>
            </div>
            <div class="honeypot" aria-hidden="true"><label for="companyFax">Company fax</label><input id="companyFax" name="companyFax" tabindex="-1" autocomplete="off"></div>
        </form>
        @endif
    </div>
</main>
@endsection
