<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','price','author_id','category_id','avgRating','image','stock'];


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
    public function scopeFilters(Builder $query, $request)
    {
        return $query
            ->when($request->filter === 'cheap', fn($q) => $q->orderBy('created_at', 'desc'))
            ->when($request->filter === 'expensive', fn($q) => $q->orderBy('created_at', 'asc'))
            ->when($request->filter === 'rating', fn($q) => $q->orderBy('avgRating', 'asc'));
    }

    public function scopeSales(Builder $query)
    {
        return $query->where('discount', '>', 0);
    }

    public function scopeNewest(Builder $query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeBestsellers(Builder $query)
    {
        return $query->orderBy('numberOfPurchased', 'desc');
    }


}
