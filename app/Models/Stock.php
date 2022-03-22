<?php

namespace App\Models;
use App\Models\User;
use App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
      'product_id','quantity','user_id'
    ];

    public function products()
    {
      return $this->hasMany(Product::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
    
}
