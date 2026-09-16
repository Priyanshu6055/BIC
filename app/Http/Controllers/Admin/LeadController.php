<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lead::query()
            ->with(['actions', 'latestAction'])
            ->search($request->input('search'))
            ->ofType($request->input('type'))
            ->ofSubType($request->input('sub_type'))
            ->ofState($request->input('state'));

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'oldest' => $query->oldest('id'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'company_asc' => $query->orderBy('company', 'asc'),
            default => $query->latest('id'),
        };

        $leads = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Lead::count(),
            'investors' => Lead::where('type', Lead::TYPE_INVESTOR)->count(),
            'startups' => Lead::where('type', Lead::TYPE_STARTUP)->count(),
            'in_progress' => Lead::whereHas('actions', fn ($q) => $q->where('state', LeadAction::STATE_IN_PROGRESS))->count(),
        ];

        return view('admin.leads.index', [
            'leads' => $leads,
            'stats' => $stats,
            'subtypesMap' => Lead::SUBTYPES,
        ]);
    }

    public function create(): View
    {
        return view('admin.leads.create', [
            'subtypesMap' => Lead::SUBTYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in([Lead::TYPE_INVESTOR, Lead::TYPE_STARTUP])],
            'sub_type' => ['required', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'mobile_no' => ['nullable', 'string', 'max:32'],
            'company' => ['nullable', 'string', 'max:255'],
            'information' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:255'],
            'initial_action' => ['nullable', 'string', 'max:255'],
            'initial_timeline' => ['nullable', 'string', 'max:255'],
            'initial_state' => ['nullable', Rule::in([LeadAction::STATE_IN_PROGRESS, LeadAction::STATE_COMPLETE])],
        ]);

        $lead = Lead::create([
            'type' => $validated['type'],
            'sub_type' => $validated['sub_type'],
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'mobile_no' => $validated['mobile_no'] ?? null,
            'company' => $validated['company'] ?? null,
            'information' => $validated['information'] ?? null,
            'source' => $validated['source'] ?? null,
        ]);

        if (! empty($validated['initial_action'])) {
            $lead->actions()->create([
                'action' => $validated['initial_action'],
                'timeline' => $validated['initial_timeline'] ?? null,
                'state' => $validated['initial_state'] ?: LeadAction::STATE_IN_PROGRESS,
            ]);
        }

        return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead): View
    {
        $lead->load('actions');

        return view('admin.leads.show', [
            'lead' => $lead,
        ]);
    }

    public function edit(Lead $lead): View
    {
        $lead->load('actions');

        return view('admin.leads.edit', [
            'lead' => $lead,
            'subtypesMap' => Lead::SUBTYPES,
        ]);
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in([Lead::TYPE_INVESTOR, Lead::TYPE_STARTUP])],
            'sub_type' => ['required', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'mobile_no' => ['nullable', 'string', 'max:32'],
            'company' => ['nullable', 'string', 'max:255'],
            'information' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        $lead->update($validated);

        return redirect()->route('admin.leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead removed successfully.');
    }

    public function storeAction(Request $request, Lead $lead): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:255'],
            'state' => ['required', Rule::in([LeadAction::STATE_IN_PROGRESS, LeadAction::STATE_COMPLETE])],
        ]);

        $action = $lead->actions()->create($validated);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Action added successfully.',
                'action' => [
                    'id' => $action->id,
                    'action' => $action->action,
                    'timeline' => $action->timeline,
                    'state' => $action->state,
                    'is_complete' => $action->isComplete(),
                    'created_at' => $action->created_at?->format('M d, Y'),
                ],
            ]);
        }

        return back()->with('success', 'Action recorded successfully.');
    }

    public function updateAction(Request $request, LeadAction $action): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:255'],
        ]);

        $action->update($validated);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Action updated successfully.',
                'action' => [
                    'id' => $action->id,
                    'action' => $action->action,
                    'timeline' => $action->timeline,
                    'state' => $action->state,
                    'is_complete' => $action->isComplete(),
                ],
            ]);
        }

        return back()->with('success', 'Action updated successfully.');
    }

    public function toggleAction(Request $request, LeadAction $action): JsonResponse|RedirectResponse
    {
        $newState = $action->isComplete() ? LeadAction::STATE_IN_PROGRESS : LeadAction::STATE_COMPLETE;
        $action->update(['state' => $newState]);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'state' => $newState,
                'is_complete' => $action->isComplete(),
                'message' => 'Action marked as ' . $newState,
            ]);
        }

        return back()->with('success', 'Action updated successfully.');
    }

    public function destroyAction(Request $request, LeadAction $action): JsonResponse|RedirectResponse
    {
        $action->delete();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Action deleted successfully.',
            ]);
        }

        return back()->with('success', 'Action deleted successfully.');
    }
}
