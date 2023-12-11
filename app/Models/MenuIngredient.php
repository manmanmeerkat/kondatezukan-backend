<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuIngredient extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'ingredient_id', 'registration_date'];

    // 関連するモデル
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
