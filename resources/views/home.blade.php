@extends('layouts.app')

@section('content')
    <div class="book-list">
        @if ($books->where('status', 'requested')->isEmpty())
            <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">No books left for approval.</h1>
        @else
        <div class="flex justify-center">
            <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Contribution Requests</h1>
        </div>
        @foreach ($books as $book)
        <div class="mt-6">
        @if ($book->status === 'requested')
        <div class="book-container">
        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div>
                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $book->title }}</h2>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Department: {{ $book->genre }}
                </p>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Condition: {{ $book->condition }}
                </p>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Requested by: <a href="{{ route('profile', $book->user) }}">{{ $book->user->name }}</a></p>
                <div class="button-container mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                <form method="post" action="{{ route('admin.approve', $book) }}">
                    @csrf
                    <button type="submit" class="approve-button rounded-lg">Approve</button>
                </form>
                <form method="post" action="{{ route('admin.decline', $book) }}">
                    @csrf
                    <button type="submit" class="decline-button rounded-lg">Decline</button>
                </form>

            </div>
        </div>
        </div>
        @endif
        @endforeach
        </div>
        @endif
    </div>
@endsection
