<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket_items extends Model
{
    use HasFactory;
    protected $fillable = ['book_id','basket_id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(Book::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
}

