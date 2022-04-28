<?php

namespace App\Models;
use App\Models\Supply;
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
        'name','username','email','gender','password','phone','role','verification_token'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];
  
    protected $casts = [
        'created_at' => 'datetime', // Change your format
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];
    
    public function supplies()
    {
      return $this->hasMany(Supply::class);
    }

    public function transactions()
    {
      return $this->hasMany(Transaction::class);
    }
}
