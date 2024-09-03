<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LandImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_id', 'url', 'caption', 'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function land()
    {
        return $this->belongsTo(Land::class, 'land_id');
    }
}
