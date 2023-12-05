<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $fillable = ['date', 'dish_id'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
