<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quote;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'quoteCount' => Quote::count(),
            'myQuoteCount' => Quote::count(),
            'favoriteCount' => Quote::where('is_favorite', true)->count(),
            'categoryCount' => Category::count(),
            'recentQuotes' => Quote::with('category')->latest()->take(5)->get(),
        ]);
    }
}
