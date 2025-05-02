<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    public mixed $priceBeforeDiscount;
    protected $fillable = ['title','description','slug','price','author_id','category_id','avgRating','image','stock'];

    protected  static function booted()
    {
        self::creating(function ($book){
            $book->slug = Str::slug($book->title);
        });
    }
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
