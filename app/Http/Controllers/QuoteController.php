<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quote;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'favorites' => ['nullable', 'boolean'],
        ]);

        $quotes = Quote::with('category')
            ->when($filters['favorites'] ?? false, fn ($query) => $query->where('is_favorite', true))
            ->when($filters['search'] ?? null, function ($query, $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('quote_text', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('category_id', $category))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('quotes.index', [
            'quotes' => $quotes,
            'categories' => Category::orderBy('category_name')->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('quotes.create', [
            'categories' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Quote::create($this->validatedQuote($request));

        return redirect()->route('quotes.index')->with('success', 'Quote added successfully.');
    }

    public function show(Quote $quote): View
    {
        return view('quotes.show', [
            'quote' => $quote->load('category'),
        ]);
    }

    public function edit(Quote $quote): View
    {
        return view('quotes.edit', [
            'quote' => $quote,
            'categories' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function update(Request $request, Quote $quote): RedirectResponse
    {
        $quote->update($this->validatedQuote($request));

        return redirect()->route('quotes.index')->with('success', 'Quote updated successfully.');
    }

    public function destroy(Quote $quote): RedirectResponse
    {
        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Quote deleted successfully.');
    }

    public function toggleFavorite(Quote $quote): RedirectResponse
    {
        $quote->is_favorite = ! $quote->is_favorite;
        $quote->save();

        return back()->with('success', $quote->is_favorite
            ? 'Quote added to your favorites.'
            : 'Quote removed from your favorites.');
    }

    private function validatedQuote(Request $request): array
    {
        return $request->validate([
            'quote_text' => ['required', 'string', 'max:2000'],
            'author' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ]);
    }
}
