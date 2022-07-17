<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\PriceType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductPrices;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    private $_getColumns = ['id', 'category_id', 'name', 'slug', 'image', 'description', 'is_active'];

    public function index()
    {
        $products = Product::with('category','prices')->OrderByIdDescending()->get($this->_getColumns);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::FilterIsActive()->get(['id', 'name']);
        $priceTypes = PriceType::FilterIsActive()->get(['id', 'name']);

        return view('products.create', compact(['categories', 'priceTypes']));
    }

    public function store(StoreProductRequest $request)
    {
        try {
                DB::transaction(function () use($request) {

                    $imageName = NULL;

                    if($request->hasFile('image')){
                        $image = $request->file('image');
                        $imageName = $this->_getFileName($image->getClientOriginalExtension());
                        $image->move(public_path('product-images'), $imageName);
                    }

                    $product = new Product; 

                    $name =  $request->name;

                    $slug = Str::slug($name);
                    $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
                    $newCount = $count > 0 ? ++$count : '';
                    $mySlug = $newCount > 0 ? "$slug-$newCount" : $slug;
                    
                    $product->name = $name;
                    $product->category_id = $request->category_id;
                    $product->slug = $mySlug;
                    $product->image = $imageName;
                    $product->description = $request->description;

                    $product->save();

                    $allPrices = $request->amount;
                    $priceTypeIds = $request->price_type_id;
                    $startDate = $request->start_date;
                    $endDate = $request->end_date;

                    $productPricesToInsert = [];

                    $createDate = date('Y-m-d H:i:s');

                    if(($allPrices !== NULL) && ($priceTypeIds !== NULL)){
                        foreach ($allPrices as $index => $amount) {
                            $productPricesToInsert[] = [
                                'product_id' => $product->id,
                                'amount' => $amount,
                                'price_type_id' => $priceTypeIds[$index],
                                'start_date' => $startDate[$index],
                                'end_date' => $endDate[$index],
                                'created_at' => $createDate,
                                'updated_at' => $createDate,
                            ];
                        }
                    }
                    ProductPrices::insert($productPricesToInsert);
                });

            } catch (QueryException $e) {

                return redirect()->route('products.index')->with(['errorMsg' => $e->getMessage()]);
            }

        return redirect()->route('products.index')->with('status', 'Product has been created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::FilterIsActive()->get(['id', 'name']);
        $priceTypes = PriceType::FilterIsActive()->get(['id', 'name']);

        return view('products.edit', compact(['product', 'categories', 'priceTypes']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use($request, $product) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = $this->_getFileName($image->getClientOriginalExtension());
                    $image->move(public_path('product-images'), $imageName);

                    if ($product->image !== NULL) {
                        if (file_exists(public_path('product-images/'. $product->image ))) {
                            unlink(public_path('product-images/'. $product->image ));
                        }
                    }

                    $product->image = $imageName;
                }

                $name = $request->name;

                $slug = Str::slug($name);
                $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
                $newCount = $count > 0 ? ++$count : '';
                $mySlug = $newCount > 0 ? "$slug-$newCount" : $slug;

                $product->name = $name;
                $product->category_id = $request->category_id;
                $product->slug = $mySlug;
                $product->description = $request->description;
                
                $product->update();

                $productPriceIds = $request->product_price_id;
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                
                $createDate=date('Y-m-d H:i:s');

                if($productPriceIds){
                    for ($i = 0; $i < count($productPriceIds); $i++) {

                        $values = [
                            'product_id' => $product->id,
                            'amount' => $request->amount[$i],
                            'start_date' => $startDate[$i],
                            'end_date' => $endDate[$i],
                            'updated_at' => $createDate,
                        ];

                        $checkId = ProductPrices::find($productPriceIds[$i]);

                        if ($checkId) {
                            $product->prices()->where('id', $checkId->id)->update($values);
                        }
                    }
                }

                $priceTypeNewIds = $request->price_type_new_id;
                $newStartDate = $request->new_start_date;
                $newEndDate = $request->new_end_date;

                    if($priceTypeNewIds){
                        for ($i = 0; $i < count($priceTypeNewIds); $i++) {
                            $newPriceTypes = [
                                'product_id' => $product->id,
                                'amount' => $request->new_amount[$i],
                                'price_type_id' => $request->price_type_new_id[$i],
                                'start_date' => $newStartDate[$i],
                                'end_date' => $newEndDate[$i],
                                'created_at' => $createDate,
                                'updated_at' => $createDate,
                            ];
                            ProductPrices::create($newPriceTypes);
                            //$product->prices()->insert($newPriceTypes);
                        }
                    }
                });

            } catch (QueryException $e) {

                return redirect()->route('products.index')->with(['errorMsg' => $e->getMessage()]);
            }

        return redirect()->route('products.index')->with('status','Product has been Updated Successfully !');
    }

    public function destroy(Product $product)
    {
        $product->prices()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('status','Product has been deleted successfully !');
    }

    public function changeStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        
        $product->update();

        return redirect()->route('products.index')->with('status','Product active status has been changed successfully !');
    }

    public function priceListDestroy($priceId)
    {
        $price = ProductPrices::find($priceId);
        $price->forceDelete();

        return redirect()->back()->with('status','Price has been changed successfully !');
    }

    private function _getFileName($fileExtension){

        // Image name format is - p-05042022121515.jpg
        return 'p-'. date("dmYhis") . '.' . $fileExtension;
    }
}
