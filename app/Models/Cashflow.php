<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    protected $fillable = [
      'operation','debet','credit','balance','user_id','notes'
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
