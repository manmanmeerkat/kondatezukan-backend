<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id', 'name', 'user_id'];

    // 食材に関連するレシピのリレーションシップ
    public function recipes()
    {
        // return $this->belongsToMany(Recipe::class, 'ingredient_recipe');
        // Ingredient モデルの recipes メソッド

        return $this->belongsToMany(Recipe::class, 'ingredient_recipe', 'ingredient_id', 'recipe_id');


        // return $this->belongsTo(Recipe::class);
    }
}
