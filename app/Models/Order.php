<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = [
        'order_status'
    ];

    protected $fillable = [
        'user_id',
        'order_date',
        'price',
        'research_result'
    ];

    public function order_status()
    {
        return $this->hasOne(Order_status::class, 'id', 'order_status_id');
    }
    
}
