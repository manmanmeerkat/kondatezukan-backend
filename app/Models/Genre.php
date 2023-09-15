<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Genre extends Model
{
    protected $fillable = ['name'];

    // ジャンルに関連するレシピのリレーションシップ
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
