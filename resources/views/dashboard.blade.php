@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="welcome-panel">
        <div class="welcome-copy">
            <div class="eyebrow"><i class="bi bi-stars me-1"></i> WELCOME TO QOUTIVERSE</div>
            <h1>Your words, all in one little universe.</h1>
            <p>A little universe of words and inspiration. Discover, create, and save meaningful quotes you want to carry with you.</p>
        </div>
        <a class="btn btn-primary welcome-action" href="{{ route('quotes.create') }}"><i class="bi bi-plus-lg me-1"></i> Add a quote</a>
        <span class="welcome-doodles" aria-hidden="true">
            <i class="bi bi-stars"></i>
            <i class="bi bi-flower1"></i>
            <i class="bi bi-heart-fill"></i>
        </span>
    </section>

    <div class="row g-3 mb-4 dashboard-stats">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="bi bi-chat-square-quote"></i></div>
                <div><div class="stat-label">Total Quotes</div><div class="stat-value">{{ $quoteCount }}</div></div>
                <a href="{{ route('quotes.index') }}" class="stat-link" aria-label="View all quotes"><i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon peach"><i class="bi bi-journal-text"></i></div>
                <div><div class="stat-label">My Quotes</div><div class="stat-value">{{ $myQuoteCount }}</div></div>
                <a href="{{ route('quotes.index') }}" class="stat-link" aria-label="View my quotes"><i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon pink"><i class="bi bi-heart"></i></div>
                <div><div class="stat-label">Favorite Quotes</div><div class="stat-value">{{ $favoriteCount }}</div></div>
                <a href="{{ route('quotes.index', ['favorites' => 1]) }}" class="stat-link" aria-label="View favorite quotes"><i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon pink"><i class="bi bi-tags"></i></div>
                <div><div class="stat-label">Categories</div><div class="stat-value">{{ $categoryCount }}</div></div>
                <a href="{{ route('categories.index') }}" class="stat-link" aria-label="View categories"><i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
    </div>

    <div class="section-heading">
        <div><h2>Recently added</h2><p>Your latest saved thoughts</p></div>
        <a href="{{ route('quotes.index') }}" class="text-link">View all <i class="bi bi-arrow-right"></i></a>
    </div>
    @if ($recentQuotes->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-journal-heart"></i></div>
            <h3>Your collection starts here</h3>
            <p>Save a quote that inspires you, and it will appear here.</p>
            <a class="btn btn-primary" href="{{ route('quotes.create') }}">Add your first quote</a>
        </div>
    @else
        <div class="row g-3">
            @foreach ($recentQuotes as $quote)
                <div class="col-md-6 col-xl-4">
                    <article class="quote-card">
                        <div class="quote-card-top">
                            <span class="category-pill">{{ $quote->category?->category_name ?? 'Uncategorized' }}</span>
                            <form action="{{ route('quotes.favorite', $quote) }}" method="POST">
                                @csrf
                                <button class="favorite-toggle {{ $quote->is_favorite ? 'is-favorite' : '' }}" type="submit" aria-label="{{ $quote->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}" aria-pressed="{{ $quote->is_favorite ? 'true' : 'false' }}" title="{{ $quote->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <i class="bi {{ $quote->is_favorite ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                </button>
                            </form>
                        </div>
                        <a class="quote-card-link" href="{{ route('quotes.show', $quote) }}">
                            <div class="quote-mark">“</div>
                            <blockquote>{{ $quote->quote_text }}</blockquote>
                        </a>
                        <div class="quote-card-footer">
                            <span class="quote-author">— {{ $quote->author }}</span>
                            <span class="quote-date">{{ $quote->created_at->format('M j, Y') }}</span>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
@endsection
