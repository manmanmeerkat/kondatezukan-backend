<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // ジャンルに関連するレシピのリレーションシップ
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
