<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function products()
    {
        return $this->hasMany(Product::class)->with('prices:id,product_id,price_type_id,amount,start_date,end_date');
    }

    public function scopeOrderByIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeFilterIsActive($query)
    {
        return $query->where('is_active', 1);
    }
}
