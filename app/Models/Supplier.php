<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'address',
        'city',
        'type',
    ];

    public function accountsPayable()
    {
        return $this->hasMany(AccountsPayable::class);
    }
}
