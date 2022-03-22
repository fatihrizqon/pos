<?php

namespace App\Models;
use App\Models\Stock;
use App\Models\Transaction;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = [
        'fullname','username','email','phone','role'
    ];

    protected $hidden = [
        'password',
    ];

    public function stocks()
    {
      return $this->hasMany(Stock::class);
    }

    public function transactions()
    {
      return $this->hasMany(Transaction::class);
    }
}
