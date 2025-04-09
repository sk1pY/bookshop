<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterfaceSite extends Model
{
    protected  $fillable = ['type','image'];
    protected $table = 'interface';
}
