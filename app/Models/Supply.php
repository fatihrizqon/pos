<?php

namespace App\Models;
use App\Models\User;
use App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
      'product_id','quantity','cost','user_id','supplier_id'
    ];

    protected $casts = [
      'created_at' => 'datetime', // Change your format
      'updated_at' => 'datetime',
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function supplier()
    {
      return $this->belongsTo(Supplier::class);
    }
}
