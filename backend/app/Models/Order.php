<?php

namespace App\Models;

use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'shipping_meta',
        'billing_meta',
        'total_amount',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function scopeOrderByIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    }
}
