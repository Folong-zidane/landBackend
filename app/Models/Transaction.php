<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_id', 'buyer_id', 'seller_id', 'price', 'status', 'transaction_date',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function land()
    {
        return $this->belongsTo(Land::class, 'land_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
