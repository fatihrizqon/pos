<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
      'product_id','product_name','quantity','price','code' 
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
