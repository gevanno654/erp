<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'city_address',
        'type',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function accountsReceivable()
    {
        return $this->hasMany(AccountsReceivable::class);
    }
}
