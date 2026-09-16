@extends('layouts.admin')
@section('title', 'Work & Leads Pipeline | BIC Administration')

@section('admin-content')
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow">Dealflow & Business Development</p>
            <h1>Work/Leads</h1>
        </div>
        <div class="admin-header-actions">
            <a class="admin-primary admin-btn-create" href="{{ route('admin.leads.create') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Add Lead</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="lead-stats-grid">
        <div class="lead-stat-card">
            <span class="stat-label">Total Leads</span>
            <strong class="stat-value">{{ $stats['total'] }}</strong>
        </div>
        <div class="lead-stat-card">
            <span class="stat-label">Investors</span>
            <strong class="stat-value text-investor">{{ $stats['investors'] }}</strong>
        </div>
        <div class="lead-stat-card">
            <span class="stat-label">Startups</span>
            <strong class="stat-value text-startup">{{ $stats['startups'] }}</strong>
        </div>
        <div class="lead-stat-card">
            <span class="stat-label">In Progress Actions</span>
            <strong class="stat-value text-progress">{{ $stats['in_progress'] }}</strong>
        </div>
    </div>

    <!-- Filter and Search Toolbar -->
    <div class="admin-toolbar">
        <form class="admin-filters lead-filters-form" method="GET" action="{{ route('admin.leads.index') }}">
            <div class="admin-search-wrap">
                <svg class="admin-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" placeholder="Search client, company, email, source..." value="{{ request('search') }}">
            </div>

            <select name="type" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="investor" @selected(request('type') === 'investor')>Investor</option>
                <option value="startup" @selected(request('type') === 'startup')>Startup</option>
            </select>

            <select name="sub_type" onchange="this.form.submit()">
                <option value="">All Sub-types</option>
                <optgroup label="Investor Sub-types">
                    @foreach($subtypesMap['investor'] as $key => $label)
                        <option value="{{ $key }}" @selected(request('sub_type') === $key)>{{ $label }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Startup Sub-types">
                    @foreach($subtypesMap['startup'] as $key => $label)
                        <option value="{{ $key }}" @selected(request('sub_type') === $key)>{{ $label }}</option>
                    @endforeach
                </optgroup>
            </select>

            <select name="state" onchange="this.form.submit()">
                <option value="">All Action States</option>
                <option value="In Progress" @selected(request('state') === 'In Progress')>In Progress</option>
                <option value="Complete" @selected(request('state') === 'Complete')>Complete</option>
            </select>

            <select name="sort" onchange="this.form.submit()">
                <option value="latest" @selected(request('sort', 'latest') === 'latest')>Sort: Newest First</option>
                <option value="oldest" @selected(request('sort') === 'oldest')>Sort: Oldest First</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Sort: Client Name (A-Z)</option>
                <option value="name_desc" @selected(request('sort') === 'name_desc')>Sort: Client Name (Z-A)</option>
                <option value="company_asc" @selected(request('sort') === 'company_asc')>Sort: Company (A-Z)</option>
            </select>

            <button type="submit" class="admin-btn-filter">Filter</button>
            @if(request()->anyFilled(['search', 'type', 'sub_type', 'state', 'sort']))
                <a href="{{ route('admin.leads.index') }}" class="admin-btn-clear">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table leads-table">
        <thead>
            <tr>
                <th style="min-width: 190px;">Client &amp; Company</th>
                <th style="min-width: 140px;">Type &amp; Category</th>
                <th style="min-width: 140px;">Contact Details</th>
                <th style="min-width: 130px;">Source</th>
                <th style="min-width: 240px;">Actions, Timeline &amp; State</th>
                <th style="width: 100px; text-align: right;">Manage</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
            <tr id="lead-row-{{ $lead->id }}">
                <!-- Client & Company (Concise) -->
                <td>
                    <div class="lead-client-info">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="lead-client-link" title="View complete lead dossier">
                            <strong class="lead-client-name">{{ $lead->name }}</strong>
                        </a>
                        @if($lead->company)
                            <span class="lead-company-name">{{ $lead->company }}</span>
                        @endif
                    </div>
                </td>

                <!-- Type & Subtype -->
                <td>
                    <div class="lead-type-wrap">
                        <span class="lead-badge lead-badge-{{ $lead->type }}">
                            {{ $lead->formatted_type }}
                        </span>
                        <span class="lead-subtype-tag">
                            {{ $lead->formatted_sub_type }}
                        </span>
                    </div>
                </td>

                <!-- Contact -->
                <td>
                    <div class="lead-contact-block">
                        @if($lead->email)
                            <a href="mailto:{{ $lead->email }}" class="lead-contact-link lead-email" title="Email {{ $lead->name }}">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>{{ $lead->email }}</span>
                            </a>
                        @endif
                        @if($lead->mobile_no)
                            <a href="tel:{{ $lead->mobile_no }}" class="lead-contact-link lead-phone" title="Call {{ $lead->mobile_no }}">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span>{{ $lead->mobile_no }}</span>
                            </a>
                        @endif
                        @if(!$lead->email && !$lead->mobile_no)
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                </td>

                <!-- Source -->
                <td>
                    <span class="lead-source-chip">{{ $lead->source ?: 'Direct / Unspecified' }}</span>
                </td>

                <!-- Actions, Timeline & State with Expandable Section -->
                <td>
                    <div class="lead-actions-cell" id="lead-actions-cell-{{ $lead->id }}">
                        <div class="lead-actions-summary">
                            @if($lead->latestAction)
                                <div class="action-preview-item" id="row-preview-{{ $lead->id }}">
                                    <span class="state-pill state-{{ Str::slug($lead->latestAction->state) }}">
                                        {{ $lead->latestAction->state }}
                                    </span>
                                    <span class="action-preview-text" title="{{ $lead->latestAction->action }}">{{ Str::limit($lead->latestAction->action, 34) }}</span>
                                    @if($lead->latestAction->timeline)
                                        <small class="action-preview-date">{{ $lead->latestAction->timeline }}</small>
                                    @endif
                                </div>
                            @else
                                <span class="no-actions-yet" id="row-preview-{{ $lead->id }}">No actions yet</span>
                            @endif

                            <button type="button" class="btn-lead-action-toggle" id="btn-toggle-{{ $lead->id }}" onclick="toggleLeadActions({{ $lead->id }})" title="Click to expand actions section below">
                                <svg class="toggle-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                                <span class="actions-count-label">{{ $lead->actions->count() }} {{ Str::plural('Action', $lead->actions->count()) }}</span>
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Manage Row Actions -->
                <td style="text-align: right;">
                    <div class="lead-row-actions">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="admin-btn-action-view" title="View complete lead dossier">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <span>View</span>
                        </a>
                        <a href="{{ route('admin.leads.edit', $lead) }}" class="admin-btn-action-edit" title="Edit entire lead on new page">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            <span>Edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Are you sure you want to remove {{ addslashes($lead->name) }}?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn-action-delete" title="Delete lead">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            <!-- Expandable Actions Section in Bottom -->
            <tr id="lead-actions-row-{{ $lead->id }}" class="lead-expanded-row" style="display: none;">
                <td colspan="6" class="lead-expanded-cell">
                    <div class="lead-expanded-panel">
                        <div class="lead-panel-top">
                            <div class="lead-panel-heading">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <strong>Actions &amp; Milestones for {{ $lead->name }}</strong>
                                <span class="lead-panel-count" id="panel-count-{{ $lead->id }}">{{ $lead->actions->count() }} {{ Str::plural('action', $lead->actions->count()) }}</span>
                                <a href="{{ route('admin.leads.show', $lead) }}" class="lead-panel-dossier-link" title="Open full dossier page">View Full Data &rarr;</a>
                            </div>
                            <button type="button" class="lead-panel-collapse-btn" onclick="toggleLeadActions({{ $lead->id }})" title="Collapse this section">
                                <span>Collapse section</span>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            </button>
                        </div>

                        <div class="lead-panel-layout">
                            <!-- Left: Action items list -->
                            <div class="lead-panel-list-col">
                                <div class="lead-panel-actions-list" id="panel-list-{{ $lead->id }}">
                                    @forelse($lead->actions as $action)
                                        <div class="lead-action-card" id="action-item-{{ $action->id }}">
                                            <div class="action-card-main">
                                                <h4 class="action-card-title">{{ $action->action }}</h4>
                                                <div class="action-card-meta">
                                                    @if($action->timeline)
                                                        <span class="action-meta-timeline">
                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                            {{ $action->timeline }}
                                                        </span>
                                                    @endif
                                                    <button type="button" 
                                                        class="state-toggle-btn state-{{ Str::slug($action->state) }}" 
                                                        onclick="toggleActionState({{ $action->id }}, this, {{ $lead->id }})"
                                                        title="Click to toggle between In Progress and Complete">
                                                        {{ $action->state }}
                                                    </button>
                                                    <span class="action-meta-date">Recorded {{ $action->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="action-card-controls">
                                                <button type="button" class="action-card-edit-btn" onclick="editActionInline({{ $action->id }}, {{ $lead->id }}, '{{ addslashes($action->action) }}', '{{ addslashes($action->timeline ?? '') }}')" title="Edit this action">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <button type="button" class="action-card-delete-btn" onclick="deleteAction({{ $action->id }}, {{ $lead->id }})" title="Remove this action">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="panel-empty" id="panel-empty-{{ $lead->id }}">
                                            No actions recorded yet. Use the form on the right to record the first follow-up action.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Right: Quick Add Form -->
                            <div class="lead-panel-form-col">
                                <form class="lead-panel-quick-form" onsubmit="submitQuickAction(event, {{ $lead->id }})">
                                    @csrf
                                    <div class="panel-form-title">+ Add Follow-up Action</div>
                                    <div class="panel-form-field">
                                        <label>Action Description <strong class="req">*</strong></label>
                                        <input type="text" name="action" placeholder="e.g. Due Diligence Call / Send Pitch Deck..." required autocomplete="off" class="quick-input-action">
                                    </div>
                                    <div class="panel-form-row">
                                        <div class="panel-form-field">
                                            <label>Timeline / Target Date</label>
                                            <input type="text" name="timeline" placeholder="e.g. Sep 30, 2026" class="quick-input-timeline">
                                        </div>
                                        <div class="panel-form-field">
                                            <label>State</label>
                                            <select name="state" class="quick-input-state">
                                                <option value="In Progress">In Progress</option>
                                                <option value="Complete">Complete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="admin-primary panel-quick-submit">
                                        + Add Action
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="admin-empty">
                    <div class="admin-empty-state">
                        <p>No leads found matching your criteria.</p>
                        <a href="{{ route('admin.leads.create') }}" class="admin-primary" style="margin-top: 12px; display: inline-flex;">+ Add Your First Lead</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($leads->hasPages())
    <div class="admin-pagination">
        {{ $leads->links() }}
    </div>
@endif

@push('head')
<script>
    // Expand / Collapse Lead Actions Section
    function toggleLeadActions(leadId) {
        const actionsRow = document.getElementById('lead-actions-row-' + leadId);
        const parentRow = document.getElementById('lead-row-' + leadId);
        const toggleBtn = document.getElementById('btn-toggle-' + leadId);

        if (!actionsRow) return;

        const isHidden = actionsRow.style.display === 'none' || actionsRow.style.display === '';

        if (isHidden) {
            actionsRow.style.display = 'table-row';
            if (parentRow) parentRow.classList.add('lead-row-expanded');
            if (toggleBtn) toggleBtn.classList.add('is-open');

            const actionInput = actionsRow.querySelector('.quick-input-action');
            if (actionInput) actionInput.focus();
        } else {
            actionsRow.style.display = 'none';
            if (parentRow) parentRow.classList.remove('lead-row-expanded');
            if (toggleBtn) toggleBtn.classList.remove('is-open');
        }
    }

    // Submit quick add action via AJAX
    async function submitQuickAction(event, leadId) {
        event.preventDefault();
        const form = event.target;
        const actionInput = form.querySelector('[name="action"]');
        const timelineInput = form.querySelector('[name="timeline"]');
        const stateSelect = form.querySelector('[name="state"]');
        const submitBtn = form.querySelector('button[type="submit"]');

        const actionVal = actionInput.value.trim();
        const timelineVal = timelineInput.value.trim();
        const stateVal = stateSelect.value;

        if (!actionVal) return;

        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                          form.querySelector('[name="_token"]')?.value;

            const response = await fetch(`/admin/leads/${leadId}/actions`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    action: actionVal,
                    timeline: timelineVal,
                    state: stateVal
                })
            });

            const data = await response.json();

            if (data.success && data.action) {
                // Prepend to actions list in expanded panel
                const list = document.getElementById('panel-list-' + leadId);
                const emptyMsg = document.getElementById('panel-empty-' + leadId);
                if (emptyMsg) emptyMsg.remove();

                const stateClass = data.action.state.toLowerCase().replace(/\s+/g, '-');
                const itemHtml = `
                    <div class="lead-action-card" id="action-item-${data.action.id}">
                        <div class="action-card-main">
                            <h4 class="action-card-title">${escapeHtml(data.action.action)}</h4>
                            <div class="action-card-meta">
                                ${data.action.timeline ? `
                                    <span class="action-meta-timeline">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        ${escapeHtml(data.action.timeline)}
                                    </span>
                                ` : ''}
                                <button type="button" 
                                    class="state-toggle-btn state-${stateClass}" 
                                    onclick="toggleActionState(${data.action.id}, this, ${leadId})"
                                    title="Click to toggle between In Progress and Complete">
                                    ${data.action.state}
                                </button>
                                <span class="action-meta-date">Recorded Just now</span>
                            </div>
                        </div>
                        <div class="action-card-controls">
                            <button type="button" class="action-card-edit-btn" onclick="editActionInline(${data.action.id}, ${leadId}, '${escapeHtml(data.action.action).replace(/'/g, "\\'")}', '${escapeHtml(data.action.timeline || '').replace(/'/g, "\\'")}')" title="Edit this action">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button type="button" class="action-card-delete-btn" onclick="deleteAction(${data.action.id}, ${leadId})" title="Remove this action">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </div>
                `;
                list.insertAdjacentHTML('afterbegin', itemHtml);

                // Update counts on panel header and row button
                updateActionCounts(leadId, 1);

                // Update latest action preview on the parent row
                updateRowPreview(leadId, data.action.action, data.action.timeline, data.action.state);

                // Reset form
                actionInput.value = '';
                timelineInput.value = '';
            } else {
                alert(data.message || 'Could not add action.');
            }
        } catch (err) {
            console.error(err);
            alert('Failed to add action. Please check connection.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = '+ Add Action';
        }
    }

    // Toggle action state between In Progress and Complete
    async function toggleActionState(actionId, btn, leadId) {
        const originalText = btn.textContent;
        btn.disabled = true;

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                          document.querySelector('[name="_token"]')?.value;

            const response = await fetch(`/admin/leads/actions/${actionId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });

            const data = await response.json();
            if (data.success) {
                btn.textContent = data.state;
                const stateClass = data.state.toLowerCase().replace(/\s+/g, '-');
                btn.className = `state-toggle-btn state-${stateClass}`;

                // If this is the first item in the list, update the row preview badge too
                const firstCard = document.querySelector(`#panel-list-${leadId} .lead-action-card`);
                if (firstCard && firstCard.id === `action-item-${actionId}`) {
                    const rowPill = document.querySelector(`#row-preview-${leadId} .state-pill`);
                    if (rowPill) {
                        rowPill.textContent = data.state;
                        rowPill.className = `state-pill state-${stateClass}`;
                    }
                }
            }
        } catch (err) {
            console.error(err);
            btn.textContent = originalText;
        } finally {
            btn.disabled = false;
        }
    }

    // Delete an action via AJAX
    async function deleteAction(actionId, leadId) {
        if (!confirm('Remove this action milestone?')) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                          document.querySelector('[name="_token"]')?.value;

            const response = await fetch(`/admin/leads/actions/${actionId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });

            const data = await response.json();
            if (data.success) {
                const el = document.getElementById('action-item-' + actionId);
                if (el) el.remove();

                updateActionCounts(leadId, -1);

                // Check if list is now empty
                const list = document.getElementById('panel-list-' + leadId);
                if (list && list.children.length === 0) {
                    list.innerHTML = `
                        <div class="panel-empty" id="panel-empty-${leadId}">
                            No actions recorded yet. Use the form on the right to record the first follow-up action.
                        </div>
                    `;
                    const preview = document.getElementById('row-preview-' + leadId);
                    if (preview) {
                        preview.innerHTML = '<span class="no-actions-yet">No actions yet</span>';
                    }
                }
            }
        } catch (err) {
            console.error(err);
            alert('Failed to delete action.');
        }
    }

    function editActionInline(actionId, leadId, currentAction, currentTimeline) {
        const cardMain = document.querySelector(`#action-item-${actionId} .action-card-main`);
        if (!cardMain) return;
        
        if (!cardMain.dataset.oldHtml) {
            cardMain.dataset.oldHtml = cardMain.innerHTML;
        }

        cardMain.innerHTML = `
            <form onsubmit="submitEditAction(event, ${actionId}, ${leadId})" class="inline-edit-form" style="display: flex; flex-direction: column; gap: 6px; width: 100%;">
                <input type="text" name="action" value="${escapeHtml(currentAction).replace(/"/g, '&quot;')}" required class="quick-input-action" style="padding: 6px; font-size: 13px; border: 1px solid var(--line); border-radius: 4px;">
                <input type="text" name="timeline" value="${escapeHtml(currentTimeline).replace(/"/g, '&quot;')}" placeholder="Timeline" class="quick-input-timeline" style="padding: 6px; font-size: 13px; border: 1px solid var(--line); border-radius: 4px;">
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="admin-primary" style="padding: 4px 12px; font-size: 11px;">Save</button>
                    <button type="button" class="admin-btn-clear" style="padding: 4px 12px; font-size: 11px;" onclick="cancelEditAction(${actionId})">Cancel</button>
                </div>
            </form>
        `;
    }

    function cancelEditAction(actionId) {
        const cardMain = document.querySelector(`#action-item-${actionId} .action-card-main`);
        if (cardMain && cardMain.dataset.oldHtml) {
            cardMain.innerHTML = cardMain.dataset.oldHtml;
        }
    }

    async function submitEditAction(event, actionId, leadId) {
        event.preventDefault();
        const form = event.target;
        const actionVal = form.querySelector('[name="action"]').value.trim();
        const timelineVal = form.querySelector('[name="timeline"]').value.trim();
        const btn = form.querySelector('button[type="submit"]');
        
        if (!actionVal) return;
        btn.disabled = true;
        btn.textContent = 'Saving...';
        
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('[name="_token"]')?.value;
            const response = await fetch(`/admin/leads/actions/${actionId}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ action: actionVal, timeline: timelineVal })
            });
            const data = await response.json();
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Could not update action.');
                btn.disabled = false;
                btn.textContent = 'Save';
            }
        } catch (err) {
            console.error(err);
            alert('Failed to update action.');
            btn.disabled = false;
            btn.textContent = 'Save';
        }
    }

    function updateActionCounts(leadId, delta) {
        // Update row button count
        const btnBadge = document.querySelector(`#btn-toggle-${leadId} .actions-count-label`);
        if (btnBadge) {
            const current = parseInt(btnBadge.textContent) || 0;
            const updated = Math.max(0, current + delta);
            btnBadge.textContent = `${updated} ${updated === 1 ? 'Action' : 'Actions'}`;
        }

        // Update panel header count
        const panelCount = document.getElementById(`panel-count-${leadId}`);
        if (panelCount) {
            const current = parseInt(panelCount.textContent) || 0;
            const updated = Math.max(0, current + delta);
            panelCount.textContent = `${updated} ${updated === 1 ? 'action' : 'actions'}`;
        }
    }

    function updateRowPreview(leadId, actionText, timeline, state) {
        const previewWrap = document.getElementById('row-preview-' + leadId);
        if (!previewWrap) return;

        const stateClass = state.toLowerCase().replace(/\s+/g, '-');
        const truncated = actionText.length > 34 ? actionText.substring(0, 34) + '...' : actionText;

        previewWrap.innerHTML = `
            <span class="state-pill state-${stateClass}">${escapeHtml(state)}</span>
            <span class="action-preview-text" title="${escapeHtml(actionText)}">${escapeHtml(truncated)}</span>
            ${timeline ? `<small class="action-preview-date">${escapeHtml(timeline)}</small>` : ''}
        `;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endpush
@endsection

