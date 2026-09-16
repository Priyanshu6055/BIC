@extends('layouts.admin')
@section('title', 'Edit Lead: ' . $lead->name . ' | BIC Administration')

@section('admin-content')
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow"><a href="{{ route('admin.leads.index') }}" style="text-decoration:none; color:inherit;">&larr; Work/Leads</a> / Editing Dealflow Entry</p>
            <h1>Edit Lead: {{ $lead->name }}</h1>
        </div>
        <div class="admin-header-actions">
            <a href="{{ route('admin.leads.index') }}" class="admin-btn-clear">Back to Leads</a>
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

<form class="admin-form-card" method="POST" action="{{ route('admin.leads.update', $lead) }}">
    @csrf
    @method('PUT')

    <div class="admin-form-section">
        <h3 class="admin-form-section-title">1. Lead Categorization</h3>
        <p class="admin-form-section-subtitle">Manage client categorization and segment.</p>

        <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr;">
            <label class="req-label">
                <span>Lead Type <strong class="req">*</strong></span>
                <select name="type" id="leadTypeSelect" required onchange="handleTypeChange(this.value)">
                    <option value="investor" @selected(old('type', $lead->type) === 'investor')>Investor</option>
                    <option value="startup" @selected(old('type', $lead->type) === 'startup')>Startup</option>
                </select>
            </label>

            <label class="req-label">
                <span>Sub-type <strong class="req">*</strong></span>
                <select name="sub_type" id="leadSubTypeSelect" required>
                    <!-- Options populated via JS -->
                </select>
                <small class="form-hint" id="subTypeHint">Options update based on selected type.</small>
            </label>
        </div>
    </div>

    <div class="admin-form-section" style="margin-top: 32px;">
        <h3 class="admin-form-section-title">2. Client &amp; Organization Details</h3>
        <p class="admin-form-section-subtitle">Update contact details, company, and background information.</p>

        <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr;">
            <label class="req-label">
                <span>Client Name <strong class="req">*</strong></span>
                <input type="text" name="name" required placeholder="e.g. Ramesh Chandra" value="{{ old('name', $lead->name) }}">
            </label>

            <label>
                <span>Company / Entity Name</span>
                <input type="text" name="company" placeholder="e.g. Acme Ventures" value="{{ old('company', $lead->company) }}">
            </label>

            <label>
                <span>Email Address</span>
                <input type="email" name="email" placeholder="client@example.com" value="{{ old('email', $lead->email) }}">
            </label>

            <label>
                <span>Mobile Number</span>
                <input type="tel" name="mobile_no" placeholder="+91 98765 43210" value="{{ old('mobile_no', $lead->mobile_no) }}">
            </label>

            <label class="wide">
                <span>Lead Generated Through (Source)</span>
                <input type="text" name="source" list="commonSources" placeholder="e.g. Referral, Website, Cold Outreach, Event, LinkedIn..." value="{{ old('source', $lead->source) }}">
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
                <textarea name="information" rows="4" placeholder="Add investment thesis, traction notes, mandate requirements, or deal background...">{{ old('information', $lead->information) }}</textarea>
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
            Update Lead Details
        </button>
        <a href="{{ route('admin.leads.index') }}" class="admin-btn-clear admin-btn-cancel">Cancel</a>
    </div>
</form>

<!-- Dedicated Action Management Panel on the Edit Page -->
<div class="admin-card" style="margin-top: 36px;">
    <div class="admin-card-header">
        <div>
            <h2 style="font-size: 18px; margin: 0 0 4px;">Tracked Actions &amp; Timeline ({{ $lead->actions->count() }})</h2>
            <p style="margin: 0; font-size: 13px; color: var(--admin-text-muted);">Manage step-by-step milestones, scheduled touchpoints, and completion state.</p>
        </div>
    </div>

    <!-- Quick Add Action in Edit Page -->
    <form class="lead-edit-add-action-form" method="POST" action="{{ route('admin.leads.actions.store', $lead) }}">
        @csrf
        <div class="edit-add-action-grid">
            <div>
                <label style="display:block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Action Description <strong style="color: #ef4444;">*</strong></label>
                <input type="text" name="action" required placeholder="e.g. Due Diligence Call / Review Terms" style="width: 100%;">
            </div>
            <div>
                <label style="display:block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Timeline</label>
                <input type="text" name="timeline" placeholder="e.g. Oct 05, 2026" style="width: 100%;">
            </div>
            <div>
                <label style="display:block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">State</label>
                <select name="state" style="width: 100%;">
                    <option value="In Progress">In Progress</option>
                    <option value="Complete">Complete</option>
                </select>
            </div>
            <div style="display: flex; align-items: flex-end;">
                <button type="submit" class="admin-primary" style="height: 40px; width: 100%; justify-content: center;">
                    + Add Action
                </button>
            </div>
        </div>
    </form>

    <!-- Table of Actions -->
    <div class="admin-table-wrap" style="margin-top: 20px; border: 1px solid var(--admin-border); border-radius: 6px;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Timeline</th>
                    <th>State</th>
                    <th>Date Added</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lead->actions as $action)
                <tr>
                    <td>
                        <strong style="color: var(--admin-text-main); font-weight: 600;">{{ $action->action }}</strong>
                    </td>
                    <td>
                        {{ $action->timeline ?: '—' }}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.leads.actions.toggle', $action) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                class="state-toggle-btn state-{{ Str::slug($action->state) }}"
                                title="Click to toggle between In Progress and Complete">
                                {{ $action->state }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <span style="font-size: 12px; color: var(--admin-text-muted);">{{ $action->created_at->format('M d, Y') }}</span>
                    </td>
                    <td style="text-align: right;">
                        <form method="POST" action="{{ route('admin.leads.actions.destroy', $action) }}" onsubmit="return confirm('Remove this action?');" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn-action-delete" title="Delete action">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--admin-text-muted); padding: 24px;">
                        No actions have been added for this lead yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('head')
<script>
    const subtypesMap = @json($subtypesMap);
    const currentSubType = @json(old('sub_type', $lead->sub_type));

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
        for (const [key, label] of Object.entries(options)) {
            const opt = document.createElement('option');
            opt.value = key;
            opt.textContent = label;
            if (key === currentSubType) {
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
