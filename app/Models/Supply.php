<?php

namespace App\Models;
use App\Models\User;
use App\Models\Stock;
use App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
      'stock_id','quantity','user_id','supplier_id'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function stock()
    {
      return $this->belongsTo(Stock::class);
    }
    public function supplier()
    {
      return $this->belongsTo(Supplier::class);
    }
}