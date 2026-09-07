<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $inquiries = Inquiry::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest()->paginate(25)->withQueryString();
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry): View
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:New,Reviewed,Contacted,Closed,Spam']]);
        $inquiry->update($data);
        return back()->with('success', 'Inquiry status updated.');
    }

    public function download(Inquiry $inquiry): StreamedResponse
    {
        abort_unless($inquiry->document_path && Storage::disk('local')->exists($inquiry->document_path), 404);
        return Storage::disk('local')->download($inquiry->document_path, $inquiry->reference.'.pdf');
    }
}

