<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['dish_id', 'name', 'user_id', 'quantity'];

    // 食材に関連するレシピのリレーションシップ
    public function dishes()
    {

        return $this->belongsToMany(Dish::class, 'ingredient_dish', 'ingredient_id', 'dish_id');
    }
}
