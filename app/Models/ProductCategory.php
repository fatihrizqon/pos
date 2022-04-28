<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
      'name'
    ];

    protected $casts = [
      'created_at' => 'datetime', // Change your format
      'updated_at' => 'datetime',
    ];
    
    public function products()
    {
      return $this->hasMany(Product::class, 'category_id');
    }

}
