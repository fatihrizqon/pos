<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    protected $fillable = [
      'operation','debet','credit','balance','user_id','notes'
    ];

    protected $casts = [
    'created_at' => 'datetime', // Change your format
    'updated_at' => 'datetime',
];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
