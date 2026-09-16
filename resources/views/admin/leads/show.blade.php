@extends('layouts.admin')
@section('title', $lead->name . ' — Lead Dossier | BIC Administration')

@section('admin-content')
<div class="admin-detail-header">
    <div class="admin-detail-title">
        <a href="{{ route('admin.leads.index') }}" class="admin-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Work/Leads
        </a>
        <div class="admin-detail-meta">
            <p class="eyebrow">{{ strtoupper($lead->type) }} &middot; {{ strtoupper($lead->formatted_sub_type) }}</p>
            <h1>{{ $lead->name }}</h1>
            <p class="admin-subtext">
                @if($lead->company)
                    <strong>{{ $lead->company }}</strong> &middot; 
                @endif
                Lead recorded on {{ $lead->created_at->format('d M Y \a\t H:i') }}
            </p>
        </div>
    </div>

    <div class="admin-detail-actions">
        <a href="{{ route('admin.leads.edit', $lead) }}" class="admin-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Edit Lead
        </a>
        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" onsubmit="return confirm('Are you sure you want to remove {{ addslashes($lead->name) }}?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-btn-clear" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);">
                Delete
            </button>
        </form>
    </div>
</div>

<div class="admin-detail">
    <!-- Contact & Classification Profile -->
    <section class="admin-card">
        <div class="admin-card-header">
            <h2>Contact &amp; Classification</h2>
        </div>
        <dl>
            <dt>Client Name</dt>
            <dd><strong>{{ $lead->name }}</strong></dd>

            <dt>Company / Entity</dt>
            <dd>{{ $lead->company ?: '—' }}</dd>

            <dt>Email Address</dt>
            <dd>
                @if($lead->email)
                    <a href="mailto:{{ $lead->email }}" class="table-link">{{ $lead->email }}</a>
                @else
                    <span class="text-muted">—</span>
                @endif
            </dd>

            <dt>Mobile Number</dt>
            <dd>
                @if($lead->mobile_no)
                    <a href="tel:{{ $lead->mobile_no }}" class="table-link">{{ $lead->mobile_no }}</a>
                @else
                    <span class="text-muted">—</span>
                @endif
            </dd>

            <dt>Classification</dt>
            <dd>
                <span class="lead-badge lead-badge-{{ $lead->type }}">{{ $lead->formatted_type }}</span>
            </dd>

            <dt>Specific Sub-type</dt>
            <dd>
                <strong>{{ $lead->formatted_sub_type }}</strong>
            </dd>

            <dt>Lead Generated Through</dt>
            <dd>
                <span class="lead-source-chip">{{ $lead->source ?: 'Direct / Unspecified' }}</span>
            </dd>

            <dt>System Record</dt>
            <dd style="font-size: 13px; color: var(--admin-text-muted);">
                Created: {{ $lead->created_at->format('M d, Y · h:i A') }}<br>
                Updated: {{ $lead->updated_at->format('M d, Y · h:i A') }}
            </dd>
        </dl>
    </section>

    <!-- Complete Information / Background Notes -->
    <section class="admin-card">
        <div class="admin-card-header">
            <h2>Background Notes &amp; Mandate Details</h2>
        </div>
        <div style="padding: 20px 24px;">
            @if($lead->information)
                <div style="font-size: 14px; line-height: 1.7; color: var(--admin-text-main); white-space: pre-wrap; background: #f8fafc; padding: 18px 20px; border-radius: 6px; border: 1px solid var(--admin-border);">{{ $lead->information }}</div>
            @else
                <p style="color: var(--admin-text-muted); font-style: italic; margin: 0;">No additional information or background notes recorded for this lead.</p>
            @endif
        </div>
    </section>
</div>

<!-- Complete Actions & Follow-up Timeline Section -->
<section class="admin-card" style="margin-top: 28px;">
    <div class="admin-card-header">
        <div>
            <h2>Tracked Actions &amp; Milestones ({{ $lead->actions->count() }})</h2>
            <p style="margin: 4px 0 0; font-size: 13px; color: var(--admin-text-muted);">Chronological record of touchpoints, deliverables, and next steps.</p>
        </div>
    </div>

    <!-- Quick Add Form inside Show Page -->
    <div style="padding: 16px 24px; background: #f8fafc; border-bottom: 1px solid var(--admin-border);">
        <form method="POST" action="{{ route('admin.leads.actions.store', $lead) }}" class="edit-add-action-grid" style="margin: 0; background: #ffffff;">
            @csrf
            <div>
                <label style="display:block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Action Description <strong style="color: #ef4444;">*</strong></label>
                <input type="text" name="action" required placeholder="e.g. Schedule due diligence call / Send teaser" style="width: 100%;">
            </div>
            <div>
                <label style="display:block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Timeline</label>
                <input type="text" name="timeline" placeholder="e.g. Sep 30, 2026" style="width: 100%;">
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
        </form>
    </div>

    <!-- Table of Actions -->
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="min-width: 250px;">Action Description</th>
                    <th style="min-width: 140px;">Timeline</th>
                    <th style="min-width: 140px;">Status</th>
                    <th style="min-width: 130px;">Date Recorded</th>
                    <th style="text-align: right; width: 80px;">Manage</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lead->actions as $action)
                <tr>
                    <td>
                        <strong style="color: var(--admin-text-main); font-size: 14px;">{{ $action->action }}</strong>
                    </td>
                    <td>
                        @if($action->timeline)
                            <span class="action-meta-timeline">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                {{ $action->timeline }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
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
                            <button type="submit" class="action-card-delete-btn" title="Delete action">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--admin-text-muted); padding: 32px 16px;">
                        No actions have been recorded for this lead yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
