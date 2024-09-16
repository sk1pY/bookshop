<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status','user_id','basket_id','price'];
    public function basket()
    {
        return $this->BelongsTo(Basket::class);
    }

    public function user(){
        return $this->BelongsTo(User::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function books(){
        return $this->belongsTo(Book::class);    }
}
