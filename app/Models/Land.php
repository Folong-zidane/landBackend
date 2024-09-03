<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'location', 'price', 'area', 'seller_id', 'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'land_id');
    }

    public function images()
    {
        return $this->hasMany(LandImage::class, 'land_id');
    }

    public function videos()
    {
        return $this->hasMany(LandVideo::class, 'land_id');
    }

    public function getPrimaryImageUrlAttribute()
    {
        return $this->images()->where('is_primary', true)->first()->url ?? null;
    }
}
