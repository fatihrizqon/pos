<?php

namespace App\Models;
use App\Models\User;
use App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'order_code','revenue','user_id'
    ];

    public function orders()
    {
      return $this->hasMany(Order::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
