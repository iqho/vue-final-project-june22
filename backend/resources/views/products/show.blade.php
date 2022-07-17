@extends('layouts.app')

@section('title','Show Product')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12  w-75">

            <div class="row justify-content-center g-0">
                <div class="col-12 text-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Product Details</h3>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="row p-3">
                                <div class="col-4">
                                    <strong>Name :</strong>
                                </div>
                                <div class="col-8">
                                    {{ $product->name }}
                                </div>
                            </div>
        
                            <div class="row p-1">
                                <div class="col-4">
                                    <strong>Category Name :</strong>
                                </div>
                                <div class="col-8">
                                    {{ $product->category->name }}
                                </div>
                            </div>
        
                            <div class="row p-1">
                                <div class="col-4">
                                    <strong>Prices :</strong>
                                </div>
                                <div class="col-8">
                                    @foreach ($product->prices as $price)
                                    <div>{{ $price->priceTypes->name }} : <strong>৳ {{ $price->amount }}</strong></div>
                                    @endforeach
                                </div>
                            </div>
        
                            <div class="row p-1">
                                <div class="col-4">
                                    <strong>Description :</strong>
                                </div>
                                <div class="col-8">
                                    {{ $product->description }}
                                </div>
                            </div>
        
                            <div class="row p-1">
                                <div class="col-4">
                                    <strong>Active Status :</strong>
                                </div>
                                <div class="col-8">
                                    @if ($product->category->is_active == 1)
                                        Active
                                    @else
                                        Deactive
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            @if ($product->image)
                                <img src="{{ asset('product-images/' . $product->image) }}"
                                height="300" width="500">                                                
                            @else
                                <small>No Image</small>
                            @endif
                        </div>



                    </div>
                </div>
            </div>  <!-- /.card -->
        </div>
    </div>
@endsection
