@extends('layouts.app')

@section('title', 'Quote')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">FROM YOUR COLLECTION</div><h1>A quote to remember</h1></div>
        <div class="d-flex gap-2">
            <a class="btn btn-light" href="{{ route('quotes.index') }}"><i class="bi bi-arrow-left me-1"></i> Back</a>
            <a class="btn btn-primary" href="{{ route('quotes.edit', $quote) }}"><i class="bi bi-pencil me-1"></i> Edit quote</a>
        </div>
    </div>
    <article class="quote-detail">
        <div class="quote-mark">“</div>
        <blockquote>{{ $quote->quote_text }}</blockquote>
        <div class="quote-author">— {{ $quote->author }}</div>
        <div class="quote-detail-meta">
            <span class="category-pill">{{ $quote->category?->category_name ?? 'Uncategorized' }}</span>
            <span>Added {{ $quote->created_at->format('F j, Y') }}</span>
            <form action="{{ route('quotes.favorite', $quote) }}" method="POST" class="ms-auto">
                @csrf
                <button class="favorite-toggle {{ $quote->is_favorite ? 'is-favorite' : '' }}" type="submit" aria-label="{{ $quote->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}" aria-pressed="{{ $quote->is_favorite ? 'true' : 'false' }}">
                    <i class="bi {{ $quote->is_favorite ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    <span>{{ $quote->is_favorite ? 'Favorited' : 'Add to favorites' }}</span>
                </button>
            </form>
        </div>
    </article>
@endsection
