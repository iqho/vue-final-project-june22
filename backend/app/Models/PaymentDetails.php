<?php

namespace App\Models;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_method_id',
        'order_id',
        'payment_meta',
    ];

    public function paymentMethods()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
