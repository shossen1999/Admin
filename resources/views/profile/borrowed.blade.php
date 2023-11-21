@extends('layouts.app')

@section('content')
<div class="borrow-list gap-6 lg:gap-8">
    @if ($borrowedBooks->where('status', 'requested')->isEmpty())
        <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">No books left for approval.</h1>
    @else
    <div class="flex justify-center">
        <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Borrowing Requests</h1>
    </div>
    <div class="mt-6">
        @foreach ($borrowedBooks as $borrowedBook)
            @if ($borrowedBook->status === 'requested')
                <div class="book-container">
                    <div class="book-details p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $borrowedBook->book->title }}</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Department: {{ $borrowedBook->book->genre }}</p>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Condition: {{ $borrowedBook->book->condition }}</p>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Requested by: <a href="{{ route('profile', $borrowedBook->user) }}">{{ $borrowedBook->user->name }}</a></p>
                            <div class="button-container mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                <form method="post" action="{{ route('adminBorrow.approve', $borrowedBook) }}">
                                    @csrf
                                    <button type="submit" class="approve-button rounded-lg">Approve</button>
                                </form>
                                <form method="post" action="{{ route('adminBorrow.decline', $borrowedBook) }}">
                                    @csrf
                                    <button type="submit" class="decline-button rounded-lg">Decline</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    @endif
</div>
@endsection
