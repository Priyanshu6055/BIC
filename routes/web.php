<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\InsightController as AdminInsightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\InsightController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/apply/{type}', [InquiryController::class, 'create'])
    ->whereIn('type', ['startup', 'msme', 'investor', 'ma', 'contact'])->name('inquiries.create');
Route::post('/apply/{type}', [InquiryController::class, 'store'])
    ->whereIn('type', ['startup', 'msme', 'investor', 'ma', 'contact'])->middleware('throttle:10,1')->name('inquiries.store');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{slug}', [InsightController::class, 'show'])->name('insights.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}', [AdminInquiryController::class, 'update'])->name('inquiries.update');
    Route::get('/inquiries/{inquiry}/document', [AdminInquiryController::class, 'download'])->name('inquiries.document');
    Route::resource('insights', AdminInsightController::class)->except(['show', 'destroy']);
});

Route::get('/robots.txt', fn () => response("User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']));
Route::get('/sitemap.xml', function () {
    $urls = collect([url('/'), route('insights.index')])
        ->merge(\App\Models\Insight::published()->pluck('slug')->map(fn ($slug) => route('insights.show', $slug)));
    return response()->view('seo.sitemap', compact('urls'))->header('Content-Type', 'application/xml');
});
