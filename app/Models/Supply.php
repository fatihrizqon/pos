<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
      'stock_id','quantity','user_id'
    ];

    public function stock()
    {
      return $this->belongsTo(Stock::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
