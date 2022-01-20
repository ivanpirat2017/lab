<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_status',
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'order_status_id', 'id');
    }

}
