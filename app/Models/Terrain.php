<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
    'nom',
    'adresse',
    'type',
    'image_path',
];

    public function matchs(): HasMany
    {
        return $this->hasMany(MatchModel::class);
    }

    public function recits(): HasMany
    {
        return $this->hasMany(Recit::class);
    }
}
