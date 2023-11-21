<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{

    public function index()
    {
        // Display a list of books on the home page
        $borrowedBooks = BorrowedBook::all();
        return view('profile.borrowed', ['borrowedBooks' => $borrowedBooks]);
    }
    public function request(Book $book)
    {
        // Handle book borrowing request logic
        $user = Auth::user();

        // Check if the user already borrowed this book
        if ($user->borrowedBooks->contains('book_id', $book->id)) {
            return back()->with('error', 'You have already borrowed this book.');
        }

        // Create a new borrowing record
        $borrowedBook = new BorrowedBook([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'return_deadline' => now()->addMonths(6),
        ]);
        $borrowedBook->save();

        return back()->with('success', 'Borrowing request sent.');
    }

    public function returnBook(Book $book)
    {
        // Handle returning a borrowed book
        $user = Auth::user();

        // Check if the user borrowed this book
        $borrowedBook = $user->borrowedBooks->where('book_id', $book->id)->first();

        if (!$borrowedBook) {
            return back()->with('error', 'You did not borrow this book.');
        }

        // Update the return date
        $borrowedBook->returned_at = now();
        $borrowedBook->save();

        return back()->with('success', 'Book returned.');
    }
    public function approve(BorrowedBook $borrowedBook)
    {
        $borrowedBook->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Book declined.');
    }
    public function decline(BorrowedBook $borrowedBook)
    {
        $borrowedBook->update(['status' => 'declined']);
        return redirect()->back()->with('success', 'Book declined.');
    }
}
