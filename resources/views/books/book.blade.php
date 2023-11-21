@extends('layouts.app')

@section('content')
    <h2>{{ $book->title }}</h2>
    <p>Genre: {{ $book->genre }}</p>
    <p>Condition: {{ $book->condition }}</p>

    <a href="{{ route('borrow.book', $book) }}">Borrow</a>
</div>
