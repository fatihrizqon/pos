<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'product_id','quantity'
    ];

    public function products()
    {
      return $this->hasMany(Product::class);
    }

    public function transaction()
    {
      return $this->belongsTo(Transaction::class);
    }
}
