<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// User Authentication Routes
Route::get('/register', 'UserController@showRegistrationForm');
Route::post('/register', 'UserController@register');
Route::get('/login', 'UserController@showLoginForm');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');

Route::post('/admin/approve/{book}', [App\Http\Controllers\BookController::class, 'approve'])->name('admin.approve');
Route::post('/admin/decline/{book}', [App\Http\Controllers\BookController::class, 'decline'])->name('admin.decline');
Route::post('/admin/approve/borrow/{borrowedBook}', [App\Http\Controllers\BorrowController::class, 'approve'])->name('adminBorrow.approve');
Route::post('/admin/decline/borrow/{borrowedBook}', [App\Http\Controllers\BorrowController::class, 'decline'])->name('adminBorrow.decline');

// Home Page
Route::get('/booklist', [App\Http\Controllers\BookController::class, 'index'])->name('book.list');
Route::get('/borrowlist', [App\Http\Controllers\BorrowController::class, 'index'])->name('borrow.list');

// User Profile
Route::get('/profile/{user}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::get('/profile/borrowed', [App\Http\Controllers\UserController::class, 'borrowed']);

// Book Contribution
Route::get('/contribute', [App\Http\Controllers\BookController::class, 'contribute']);
Route::post('/contribute', [App\Http\Controllers\BookController::class, 'store'])->name('book.store');

// Book Borrowing
Route::match(['get', 'post'], '/borrow/{book}', [App\Http\Controllers\BorrowController::class, 'request'])->name('borrow.book');
Route::get('/return/{book}', [App\Http\Controllers\BorrowController::class, 'returnBook']);

// Book Details
Route::get('/book/{book}', [App\Http\Controllers\BookController::class, 'show'])->name('book.show');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
