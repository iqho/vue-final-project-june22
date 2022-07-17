<?php

namespace App\Http\Controllers;

use App\Models\PriceType;
use Illuminate\Http\Request;
use App\Models\ProductPrices;
use Illuminate\Database\QueryException;
use App\Http\Requests\PriceType\StorePriceTypeRequest;
use App\Http\Requests\PriceType\UpdatePriceTypeRequest;

class PriceTypeController extends Controller
{
    private $_getColumns = ['id', 'name', 'is_active'];
    
    public function index()
    {
        $priceTypes = PriceType::get($this->_getColumns);

        return view('price-types.index', compact('priceTypes'));
    }

    public function create()
    {
        return view('price-types.create');
    }

    public function store(StorePriceTypeRequest $request)
    {
        try 
        {
            $priceType = new PriceType; 

            $priceType->name = $request->name;

            $priceType->save();

        } catch (QueryException $e) {
            return redirect()->route('priceTypes.index')->with('errorMsg', $e->getMessage());
        }

        return redirect()->route('priceTypes.index')->with('status', 'Price Type has been created successfully.');
    }

    public function show(PriceType $priceType)
    {
        return view('price-types.show', compact('priceType'));
    }

    public function edit(PriceType $priceType)
    {
        return view('price-types.edit', compact('priceType'));
    }

    public function update(UpdatePriceTypeRequest $request, PriceType $priceType)
    {
        try 
        {
            $priceType->name = $request->name;

            $priceType->update();

        } catch (QueryException $e) {
            return redirect()->route('priceTypes.index')->with('errorMsg', $e->getMessage());
        }

        return redirect()->route('priceTypes.index')->with('status', 'Price Type has been updated successfully.');
    }

    public function destroy(PriceType $priceType)
    {
        $productPrices = ProductPrices::where('price_type_id', $priceType->id)
                                        ->count();

        if ($productPrices == 0) {
            $priceType->delete();
        } 
        else {
            return redirect()->route('priceTypes.index')->with('errorMsg', 'This Price Type has products price. You can not delete it.');
        }
        
        return redirect()->route('priceTypes.index')->with('status','Price Type has been deleted successfully !');
    }

    public function changeStatus(PriceType $priceType)
    {        
        $priceType->is_active = !$priceType->is_active;

        $priceType->update();

        return redirect()->route('priceTypes.index')->with('status','Price Type active status has been changed successfully !');
    }
}
