<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;

    protected $table = 'borrowed_books';

    protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'return_deadline', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }

}
