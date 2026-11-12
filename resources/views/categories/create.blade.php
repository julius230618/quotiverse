@extends('layouts.app')

@section('title', 'Add a category')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">A PLACE FOR EVERY IDEA</div><h1>Add a category</h1><p class="page-subtitle">Create a new theme for your quote collection.</p></div>
    </div>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories._form', ['submitLabel' => 'Save category'])
    </form>
@endsection
