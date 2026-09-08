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
        $inquiries = $this->filteredQuery($request)
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function export(Request $request): StreamedResponse
    {
        $format = strtolower($request->input('format', 'csv'));
        $query = $this->filteredQuery($request)->latest();
        $filename = 'bic-inquiries-' . now()->format('Y-m-d-His');

        if ($format === 'json') {
            return response()->streamDownload(function () use ($query) {
                echo json_encode($query->get(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }, "{$filename}.json", ['Content-Type' => 'application/json']);
        }

        // Default Excel-compatible CSV export
        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for seamless Microsoft Excel rendering
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Reference',
                'Date',
                'Type',
                'Client Name',
                'Email Address',
                'Phone',
                'Company',
                'Status',
                'Has Document',
                'Submission Details',
            ]);

            $query->chunk(200, function ($inquiries) use ($handle) {
                foreach ($inquiries as $inquiry) {
                    $details = collect($inquiry->payload ?? [])
                        ->map(fn ($val, $key) => str($key)->headline() . ': ' . (is_bool($val) ? ($val ? 'Yes' : 'No') : (is_array($val) ? implode(', ', $val) : $val)))
                        ->implode(' | ');

                    fputcsv($handle, [
                        $inquiry->reference,
                        $inquiry->created_at?->format('Y-m-d H:i:s'),
                        strtoupper($inquiry->type),
                        $inquiry->name,
                        $inquiry->email,
                        $inquiry->phone,
                        $inquiry->company ?: '—',
                        $inquiry->status,
                        $inquiry->document_path ? 'Yes' : 'No',
                        $details,
                    ]);
                }
            });

            fclose($handle);
        }, "{$filename}.csv", [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ]);
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

    private function filteredQuery(Request $request)
    {
        return Inquiry::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = trim((string) $request->input('search'));
                $q->where(function ($query) use ($search) {
                    $query->where('reference', 'like', "%{$search}%")
                          ->orWhere('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('company', 'like', "%{$search}%")
                          ->orWhere('phone', 'like', "%{$search}%")
                          ->orWhere('type', 'like', "%{$search}%")
                          ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('type'), function ($q) use ($request) {
                $type = trim((string) $request->input('type'));
                $q->where('type', $type);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $status = trim((string) $request->input('status'));
                $q->where('status', $status);
            });
    }
}
