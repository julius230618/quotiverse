@extends('layouts.app')

@section('title', 'All quotes')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">YOUR COLLECTION</div>
            <h1>All quotes</h1>
            <p class="page-subtitle">Browse and revisit the words you have saved.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('quotes.create') }}"><i class="bi bi-plus-lg me-1"></i> Add a quote</a>
    </div>

    <form class="filter-bar" action="{{ route('quotes.index') }}" method="GET">
        <div class="search-field"><i class="bi bi-search"></i><input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search quotes or authors..." aria-label="Search quotes or authors"></div>
        <select class="form-select category-filter" name="category" aria-label="Filter by category">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(($filters['category'] ?? '') == $category->id)>{{ $category->category_name }}</option>
            @endforeach
        </select>
        <label class="favorite-filter">
            <input class="form-check-input" type="checkbox" name="favorites" value="1" @checked($filters['favorites'] ?? false)>
            <span><i class="bi bi-heart-fill"></i> Favorites</span>
        </label>
        <button class="btn btn-primary" type="submit">Filter</button>
        @if (!empty($filters))
            <a class="btn btn-light" href="{{ route('quotes.index') }}">Clear</a>
        @endif
    </form>

    @if ($quotes->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-search-heart"></i></div>
            <h3>{{ $filters ? 'No quotes found' : 'No quotes yet' }}</h3>
            <p>{{ $filters ? 'Try another search or clear the filters.' : 'Add your first quote to begin your collection.' }}</p>
            @if ($filters)
                <a class="btn btn-outline-primary" href="{{ route('quotes.index') }}">Clear filters</a>
            @else
                <a class="btn btn-primary" href="{{ route('quotes.create') }}">Add your first quote</a>
            @endif
        </div>
    @else
        <div class="collection-meta">
            {{ $quotes->total() }} {{ \Illuminate\Support\Str::plural('quote', $quotes->total()) }}
            {{ ($filters['favorites'] ?? false) ? 'in your favorites' : 'in your collection' }}
        </div>
        <div class="row g-3">
            @foreach ($quotes as $quote)
                <div class="col-md-6 col-xl-4">
                    <article class="quote-card">
                        <div class="quote-card-top">
                            <span class="category-pill">{{ $quote->category?->category_name ?? 'Uncategorized' }}</span>
                            <div class="quote-card-tools">
                                <span class="quote-date">{{ $quote->created_at->format('M j, Y') }}</span>
                                <form action="{{ route('quotes.favorite', $quote) }}" method="POST">
                                    @csrf
                                    <button class="favorite-toggle {{ $quote->is_favorite ? 'is-favorite' : '' }}" type="submit" aria-label="{{ $quote->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}" aria-pressed="{{ $quote->is_favorite ? 'true' : 'false' }}" title="{{ $quote->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                        <i class="bi {{ $quote->is_favorite ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <a class="quote-card-link" href="{{ route('quotes.show', $quote) }}">
                            <div class="quote-mark">“</div>
                            <blockquote>{{ $quote->quote_text }}</blockquote>
                        </a>
                        <div class="quote-card-footer">
                            <span class="quote-author">— {{ $quote->author }}</span>
                            <div class="card-actions">
                                <a class="icon-button" href="{{ route('quotes.edit', $quote) }}" aria-label="Edit quote"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Delete this quote? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="icon-button danger" type="submit" aria-label="Delete quote"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $quotes->links() }}</div>
    @endif
@endsection
