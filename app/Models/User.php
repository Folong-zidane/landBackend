<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
   
    protected $fillable = [
        'name','password', 'role', 'phone', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

   

    public function lands()
    {
        return $this->hasMany(Land::class, 'seller_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id')->orHas('seller_id', $this->id);
    }

    public function adminActions()
    {
        return $this->hasMany(AdminAction::class, 'admin_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
