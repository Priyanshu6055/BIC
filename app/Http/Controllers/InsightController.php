<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function index(): View
    {
        return view('insights.index', ['insights' => Insight::published()->latest('published_at')->paginate(12)]);
    }

    public function show(string $slug): View
    {
        $insight = Insight::published()->where('slug', $slug)->firstOrFail();
        $relatedInsights = Insight::published()
            ->where('id', '!=', $insight->id)
            ->where(function ($query) use ($insight) {
                if ($insight->category) {
                    $query->where('category', $insight->category);
                }
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedInsights->count() < 3) {
            $more = Insight::published()
                ->where('id', '!=', $insight->id)
                ->whereNotIn('id', $relatedInsights->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedInsights->count())
                ->get();
            $relatedInsights = $relatedInsights->merge($more);
        }

        return view('insights.show', compact('insight', 'relatedInsights'));
    }
}

