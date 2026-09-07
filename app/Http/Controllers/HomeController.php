<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'insights' => Insight::published()->latest('published_at')->limit(3)->get(),
        ]);
    }
}

