<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InsightController extends Controller
{
    public function index(Request $request): View
    {
        $insights = $this->filteredQuery($request)
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $categories = Insight::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('admin.insights.index', compact('insights', 'categories'));
    }

    public function export(Request $request): StreamedResponse
    {
        $format = strtolower($request->input('format', 'csv'));
        $query = $this->filteredQuery($request)->latest();
        $filename = 'bic-insights-' . now()->format('Y-m-d-His');

        if ($format === 'json') {
            return response()->streamDownload(function () use ($query) {
                echo json_encode($query->get(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }, "{$filename}.json", ['Content-Type' => 'application/json']);
        }

        // Default Excel-compatible CSV export
        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Title',
                'Category',
                'Author',
                'Status',
                'Featured',
                'Published Date',
                'Slug',
                'SEO Meta Title',
                'Summary Excerpt',
            ]);

            $query->chunk(200, function ($insights) use ($handle) {
                foreach ($insights as $insight) {
                    fputcsv($handle, [
                        $insight->id,
                        $insight->title,
                        $insight->category ?: '—',
                        $insight->author ?: '—',
                        ucfirst($insight->status),
                        $insight->featured ? 'Yes' : 'No',
                        $insight->published_at?->format('Y-m-d H:i') ?: '—',
                        $insight->slug,
                        $insight->seo_title ?: '—',
                        $insight->summary,
                    ]);
                }
            });

            fclose($handle);
        }, "{$filename}.csv", [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ]);
    }

    public function create(): View
    {
        return view('admin.insights.form', ['insight' => new Insight]);
    }

    public function store(Request $request): RedirectResponse
    {
        $insight = Insight::create($this->validated($request));
        return redirect()->route('admin.insights.edit', $insight)->with('success', 'Insight created.');
    }

    public function edit(Insight $insight): View
    {
        return view('admin.insights.form', compact('insight'));
    }

    public function update(Request $request, Insight $insight): RedirectResponse
    {
        $insight->update($this->validated($request, $insight));
        return back()->with('success', 'Insight updated.');
    }

    public function destroy(Insight $insight): RedirectResponse
    {
        if ($insight->cover_image && str_starts_with($insight->cover_image, 'storage/')) {
            Storage::disk('public')->delete(Str::after($insight->cover_image, 'storage/'));
        }

        $title = $insight->title;
        $insight->delete();

        return redirect()->route('admin.insights.index')->with('success', "Insight \"{$title}\" was successfully deleted.");
    }

    private function filteredQuery(Request $request)
    {
        return Insight::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = trim((string) $request->input('search'));
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('author', 'like', "%{$search}%")
                          ->orWhere('category', 'like', "%{$search}%")
                          ->orWhere('summary', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($q) use ($request) {
                $category = trim((string) $request->input('category'));
                $q->where('category', $category);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $status = trim((string) $request->input('status'));
                $q->where('status', $status);
            });
    }

    private function validated(Request $request, ?Insight $insight = null): array
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255', Rule::unique('insights')->ignore($insight)],
            'summary' => ['required','string','max:1000'],
            'body' => ['required','string'],
            'cover_upload' => ['nullable','image','max:5120'],
            'alt_text' => ['nullable','string','max:255'],
            'author' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:120'],
            'status' => ['required', Rule::in(['draft','published','archived'])],
            'featured' => ['sometimes','boolean'],
            'published_at' => ['nullable','date'],
            'seo_title' => ['nullable','string','max:255'],
            'seo_description' => ['nullable','string','max:320'],
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['featured'] = $request->boolean('featured');
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        if ($request->hasFile('cover_upload')) {
            if ($insight?->cover_image && str_starts_with($insight->cover_image, 'storage/')) {
                Storage::disk('public')->delete(Str::after($insight->cover_image, 'storage/'));
            }
            $data['cover_image'] = 'storage/'.$request->file('cover_upload')->store('insights', 'public');
        }
        unset($data['cover_upload']);
        return $data;
    }
}
