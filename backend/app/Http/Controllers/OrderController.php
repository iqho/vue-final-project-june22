<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $_getColumns = ['id', 'order_number', 'shipping_meta', 'billing_meta', 'total_amount', 'created_at'];

    public function index()
    {
        $orders = Order::OrderByIdDescending()->get($this->_getColumns);
       // $orderStatus = OrderStatus::get(['id','name']);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = Order::with('orderDetails')->find($order->id);
        return view('orders.show', compact('order'));
    }

    public function changeDeliveryStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->order_status_id = $request->order_status_id;
        $order->save();
        return response()->json(['success' => 'Price Type Active Status Change Successfully.']);
    }


}
