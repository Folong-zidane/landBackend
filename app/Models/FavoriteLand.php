<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteLand extends Model
{
    protected $fillable = ['user_id', 'land_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }
}
