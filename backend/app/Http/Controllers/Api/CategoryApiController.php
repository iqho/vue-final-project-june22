<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryApiController extends Controller
{
    public function getCategories()
    {
        $categories = Category::with('products:id,category_id,name,slug,image,description')
                                ->where('is_active', true)
                                ->get(['id', 'name', 'slug']);
        
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function getSingleCategory(Category $category)
    {
        $category = Category::with('products:id,category_id,name,slug,image,description',)
                            ->where('slug', $category->slug)    
                            ->where('is_active', true)->first(['id', 'name', 'slug']);
        
        return response()->json([
            'category' => $category
        ], 200);
    }
}
