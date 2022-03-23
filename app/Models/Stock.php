<?php

namespace App\Models;
use App\Models\Supply;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
      'product_id','quantity'
    ];

    public function products()
    {
      return $this->hasMany(Product::class);
    }

    public function supply()
    {
      return $this->hasMany(Supply::class);
    }
  
}
