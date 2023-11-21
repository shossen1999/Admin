<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'genre', 'condition', 'cover_image', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function borrowedBy()
    {
        return $this->hasMany(BorrowedBook::class);
    }

}
