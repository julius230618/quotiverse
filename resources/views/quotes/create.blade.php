@extends('layouts.app')

@section('title', 'Add a quote')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">NEW INSPIRATION</div><h1>Add a quote</h1><p class="page-subtitle">Save a thought you want to carry with you.</p></div>
    </div>
    <form action="{{ route('quotes.store') }}" method="POST">
        @csrf
        @include('quotes._form', ['submitLabel' => 'Save quote'])
    </form>
@endsection
