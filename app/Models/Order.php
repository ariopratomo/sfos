<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'cashier_name',
        'waiter_name',
        'payment_method',
        'total_price',
        'status',
        'total_qty',
    ];

    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }



}
