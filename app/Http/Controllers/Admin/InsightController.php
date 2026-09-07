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

class InsightController extends Controller
{
    public function index(Request $request): View
    {
        $insights = Insight::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search');
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('author', 'like', "%{$search}%")
                          ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest()->paginate(25)->withQueryString();
        return view('admin.insights.index', compact('insights'));
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
