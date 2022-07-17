<?php

namespace App\Models;

use App\Models\PaymentDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetails::class);
    }
}
