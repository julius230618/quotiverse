@extends('layouts.app')

@section('title', 'Edit category')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">KEEP THINGS ORGANIZED</div><h1>Edit category</h1><p class="page-subtitle">Rename this collection theme.</p></div>
    </div>
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categories._form', ['submitLabel' => 'Save changes'])
    </form>
@endsection
