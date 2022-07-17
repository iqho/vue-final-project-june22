<?php

namespace App\Models;

use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrices extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'price_type_id',
        'amount',
        'start_date',
        'end_date',
    ];


    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function priceTypes()
    {
        return $this->belongsTo(PriceType::class, 'price_type_id');
    }
}
