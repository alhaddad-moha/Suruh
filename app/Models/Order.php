<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public function approve()
    {
        return $this->hasOne(Approve::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
