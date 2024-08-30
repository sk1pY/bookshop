<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function basket_items()
    {
        return $this->hasMany(Basket_items::class);
    }
}
