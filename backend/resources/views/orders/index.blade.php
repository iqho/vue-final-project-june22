@extends('layouts.app')

@section('title', 'All Orders')

@section('content')

    <div class="row justify-content-center mb-2">
        <div class="col-md-12">

            <div class="row justify-content-center g-0 mb-2">
                <div class="col-12 text-end">
                    <a class="btn btn-primary" href="{{ route('home') }}">Back</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Orders List</h3>
                </div>
                <div class="card-body">

                    @if (session('status'))
                        <div class="row">
                            <div class="col-12 alert alert-success text-center" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order Number</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Shipping Address</th>
                                    <th class="text-center">Billing Address</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl =1;
                                @endphp
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($order->created_at)); }}</td>
                                        <td class="text-center">
                                            @foreach (json_decode($order->shipping_meta) as $key => $meta)
                                                {{ $meta }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach (json_decode($order->billing_meta) as $key => $meta)
                                                {{ $meta }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                          {{ $order->total_amount }}
                                        </td>
                                        <td class="text-center">
                                          <div class="btn-group" role="group">
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn  btn-primary me-1"><i class="fa fa-eye"></i>
                                            </a>
                                          </div>
                                      </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


