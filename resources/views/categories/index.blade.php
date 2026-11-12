@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">ORGANIZE YOUR THOUGHTS</div><h1>Categories</h1><p class="page-subtitle">Group your quotes by the ideas that matter to you.</p></div>
        <a class="btn btn-primary" href="{{ route('categories.create') }}"><i class="bi bi-plus-lg me-1"></i> Add category</a>
    </div>
    <div class="table-card">
        @if ($categories->isEmpty())
            <div class="empty-state compact">
                <div class="empty-icon"><i class="bi bi-tags"></i></div>
                <h3>No categories yet</h3>
                <p>Create categories to keep your quotes organized.</p>
                <a class="btn btn-primary" href="{{ route('categories.create') }}">Create a category</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Category</th><th>Quotes</th><th>Created</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td><span class="category-dot"></span><strong>{{ $category->category_name }}</strong></td>
                                <td>{{ $category->quotes_count }}</td>
                                <td>{{ $category->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a class="btn btn-sm btn-light" href="{{ route('categories.edit', $category) }}">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category? Its quotes will become uncategorized.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
