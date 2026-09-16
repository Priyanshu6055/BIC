@extends('layouts.admin')
@section('title', 'Add New Lead | BIC Administration')

@section('admin-content')
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow"><a href="{{ route('admin.leads.index') }}" style="text-decoration:none; color:inherit;">&larr; Work/Leads</a> / New Dealflow Entry</p>
            <h1>Add New Lead</h1>
        </div>
        <div class="admin-header-actions">
            <a href="{{ route('admin.leads.index') }}" class="admin-btn-clear">Cancel</a>
        </div>
    </div>
</div>

@if(isset($errors) && $errors->any())
    <div class="admin-alert admin-alert-error" role="alert" style="margin-bottom: 24px; padding: 16px 20px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; color: #991b1b;">
        <strong style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Please correct the errors below:</strong>
        <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="admin-form-card" method="POST" action="{{ route('admin.leads.store') }}">
    @csrf

    <div class="admin-form-section">
        <h3 class="admin-form-section-title">1. Lead Categorization</h3>
        <p class="admin-form-section-subtitle">Select the classification and specific subtype for this lead.</p>

        <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr;">
            <label class="req-label">
                <span>Lead Type <strong class="req">*</strong></span>
                <select name="type" id="leadTypeSelect" required onchange="handleTypeChange(this.value)">
                    <option value="">— Select Type —</option>
                    <option value="investor" @selected(old('type') === 'investor')>Investor</option>
                    <option value="startup" @selected(old('type') === 'startup')>Startup</option>
                </select>
            </label>

            <label class="req-label">
                <span>Sub-type <strong class="req">*</strong></span>
                <select name="sub_type" id="leadSubTypeSelect" required>
                    <option value="">— Select Type First —</option>
                </select>
                <small class="form-hint" id="subTypeHint">Options will update based on selected type.</small>
            </label>
        </div>
    </div>

    <div class="admin-form-section" style="margin-top: 32px;">
        <h3 class="admin-form-section-title">2. Client &amp; Organization Details</h3>
        <p class="admin-form-section-subtitle">Key contact points and background information.</p>

        <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr;">
            <label class="req-label">
                <span>Client Name <strong class="req">*</strong></span>
                <input type="text" name="name" required placeholder="e.g. Ramesh Chandra / Sarah Khan" value="{{ old('name') }}">
            </label>

            <label>
                <span>Company / Entity Name</span>
                <input type="text" name="company" placeholder="e.g. Acme Ventures / NovaTech Pvt Ltd" value="{{ old('company') }}">
            </label>

            <label>
                <span>Email Address</span>
                <input type="email" name="email" placeholder="client@example.com" value="{{ old('email') }}">
            </label>

            <label>
                <span>Mobile Number</span>
                <input type="tel" name="mobile_no" placeholder="+91 98765 43210" value="{{ old('mobile_no') }}">
            </label>

            <label class="wide">
                <span>Lead Generated Through (Source)</span>
                <input type="text" name="source" list="commonSources" placeholder="e.g. Referral, Website, Cold Outreach, Event, LinkedIn..." value="{{ old('source') }}">
                <datalist id="commonSources">
                    <option value="Direct Referral">
                    <option value="BIC Website Form">
                    <option value="Inbound Email">
                    <option value="Cold Outreach">
                    <option value="Conference / Summit">
                    <option value="LinkedIn Networking">
                    <option value="Advisory Partner">
                </datalist>
            </label>

            <label class="wide">
                <span>Information / Background Notes</span>
                <textarea name="information" rows="4" placeholder="Add investment thesis, traction notes, mandate requirements, or deal background...">{{ old('information') }}</textarea>
            </label>
        </div>
    </div>

    <div class="admin-form-section" style="margin-top: 32px;">
        <h3 class="admin-form-section-title">3. Initial Action &amp; Follow-up</h3>
        <p class="admin-form-section-subtitle">Optional initial action item, target timeline, and current progress state.</p>

        <div class="admin-form-grid" style="grid-template-columns: 2fr 1fr 1fr;">
            <label>
                <span>Action Description</span>
                <input type="text" name="initial_action" placeholder="e.g. Schedule intro call / Request data room access" value="{{ old('initial_action') }}">
            </label>

            <label>
                <span>Timeline</span>
                <input type="text" name="initial_timeline" placeholder="e.g. Sep 25, 2026" value="{{ old('initial_timeline') }}">
            </label>

            <label>
                <span>State</span>
                <select name="initial_state">
                    <option value="In Progress" @selected(old('initial_state', 'In Progress') === 'In Progress')>In Progress</option>
                    <option value="Complete" @selected(old('initial_state') === 'Complete')>Complete</option>
                </select>
            </label>
        </div>
    </div>

    <div class="admin-form-actions">
        <button type="submit" class="admin-primary admin-btn-save">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            Save Lead
        </button>
        <a href="{{ route('admin.leads.index') }}" class="admin-btn-clear admin-btn-cancel">Cancel</a>
    </div>
</form>

@push('head')
<script>
    const subtypesMap = @json($subtypesMap);
    const oldSubType = @json(old('sub_type', ''));

    function handleTypeChange(selectedType) {
        const subSelect = document.getElementById('leadSubTypeSelect');
        const hint = document.getElementById('subTypeHint');
        subSelect.innerHTML = '';

        if (!selectedType || !subtypesMap[selectedType]) {
            subSelect.innerHTML = '<option value="">— Select Type First —</option>';
            hint.textContent = 'Options will update based on selected type.';
            return;
        }

        const options = subtypesMap[selectedType];
        subSelect.innerHTML = '<option value="">— Select Sub-type —</option>';

        for (const [key, label] of Object.entries(options)) {
            const opt = document.createElement('option');
            opt.value = key;
            opt.textContent = label;
            if (key === oldSubType) {
                opt.selected = true;
            }
            subSelect.appendChild(opt);
        }

        if (selectedType === 'investor') {
            hint.textContent = 'Investor options: Corporate, MSME, Family Office, HNI';
        } else if (selectedType === 'startup') {
            hint.textContent = 'Startup options: MSME Startup, Newway Startup';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const initialType = document.getElementById('leadTypeSelect').value;
        if (initialType) {
            handleTypeChange(initialType);
        }
    });
</script>
@endpush
@endsection
