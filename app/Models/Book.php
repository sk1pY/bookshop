<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','price','author_id','category_id','avgRating'];


    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function basket_items()
    {
        return $this->hasMany(BasketItem::class);
    }

    public function commentaries(){
        return $this->hasMany(Commentary::class);
    }



}
