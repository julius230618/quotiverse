@extends('layouts.app')

@section('title', 'Edit quote')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">REFINE YOUR COLLECTION</div><h1>Edit quote</h1><p class="page-subtitle">Make a change to this saved quote.</p></div>
    </div>
    <form action="{{ route('quotes.update', $quote) }}" method="POST">
        @csrf
        @method('PUT')
        @include('quotes._form', ['submitLabel' => 'Save changes'])
    </form>
@endsection
