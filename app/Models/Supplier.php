<?php

namespace App\Models;
use App\Models\Supply;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
      'name','address','email','contact'
    ];

    protected $casts = [
      'created_at' => 'datetime', // Change your format
      'updated_at' => 'datetime',
    ];

    public function supplies()
    {
      return $this->hasMany(Supply::class);
    }
}
