<?php

namespace App\Models;

use App\Models\Category;
use App\Models\OrderDetails;
use App\Models\ProductPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrices::class)->with('priceTypes:id,name,is_active');
    }

    public function currentPrice()
    {
        return $this->hasOne(ProductPrices::class)
                    ->with('priceTypes:id,name')
                    ->where('start_date', '<=', date('Y-m-d'))
                    ->where('end_date', '>=', date('Y-m-d'));
    }

    public function orderDetails()
    {
        return $this->belongsTo(OrderDetails::class);
    }

    public function scopeOrderByIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeFilterIsActive($query)
    {
        return $query->where('is_active', true);
    }
}
