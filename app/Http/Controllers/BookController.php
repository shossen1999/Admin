<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    public function index()
    {
        // Display a list of books on the home page
        $books = Book::all();
        return view('home', ['books' => $books]);
    }

    public function contribute()
    {
        // Display the book contribution form
        return view('books.contribute');
    }

    public function store(Request $request)
    {
        // Validate the book contribution form data
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'condition' => 'required',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create a new book in the database and associate it with the logged-in user
        $user = Auth::user();
        $book = new Book([
            'title' => $request->title,
            'genre' => $request->genre,
            'condition' => $request->condition,
            'cover_image' => $request->cover_image,
        ]);
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $path = $coverImage->store('public/images'); // Store the image in the 'public/images' directory

            $book->cover_image = $path; // Store the path in the database
        }

        $user->books()->save($book);

        // Redirect to the home page with a success message
        return redirect('/')->with('success', 'Book contribution added and pending approval');
    }

    public function show(Book $book)
    {
        // Display an individual book's details
        return view('books.book', ['book' => $book]);
    }
    public function approve(Book $book)
    {
        $book->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Book approved successfully.');
    }
    public function decline(Book $book)
    {
        $book->update(['status' => 'declined']);
        return redirect()->back()->with('success', 'Book declined.');
    }

}
