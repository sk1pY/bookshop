<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;


    protected static function booted()
    {
        self::creating(function ($author) {
            $author->slug = Str::slug($author->name.' '.$author->surname);
        });
    }

    protected $fillable = ['name', 'surname', 'slug'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
