<?php

namespace App\Models;
use App\Models\Order;
use App\Models\Stock;
use App\Models\ProductCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
      'name','price','category_id'
    ];

    public function order()
    {
      return $this->belongsTo(Order::class);
    }

    public function stock()
    {
      return $this->belongsTo(Stock::class);
    }

    public function productCategory()
    {
      return $this->belongsTo(ProductCategory::class, 'id');
    }
}
