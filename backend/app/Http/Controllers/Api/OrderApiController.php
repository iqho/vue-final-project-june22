<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\PaymentDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class OrderApiController extends Controller
{
    private $_getColumns = ['id', 'category_id', 'name', 'slug', 'image', 'description', 'is_active'];

    public function index()
    {
        $orders = Order::with('orderDetails')->get($this->_getColumns);
        $products = Product::get(['id','name','image']);
        
        return response()->json([
            'orders' => $orders,
            'products' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use($request)
            {
                $shipping_meta = $request->only('shippingFullName', 'shippingContactNumber', 'shippingAddress');
                $billing_meta = $request->only('billingFullName', 'billingContactNumber', 'billingAddress');

                $orderNumber = $this->_generateRandomOrderNumber();

                $order = new Order;
                
                $order->user_id = 1;
                $order->order_number = $orderNumber;
                $order->shipping_meta = json_encode($shipping_meta);
                $order->billing_meta = json_encode($billing_meta);
                $order->total_amount = $request->total_amount;

                $order->save();

                $cartItems = $request['cartItems'];
                foreach ($cartItems as $cartItem) {
                    $cartItems2[] = [
                        'order_id' => $order->id,
                        'product_id' => $cartItem['id'],
                        'product_name' => $cartItem['name'],
                        'price' => $cartItem['price'],
                        'quantity' => $cartItem['quantity'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                }
                
                OrderDetails::insert($cartItems2);

                $paymentDetails = new PaymentDetails;

                $paymentDetails->order_id = $order->id;
                $paymentDetails->payment_method_id = $request->paymentMethodId;

                if($request->paymentMethodId == 1)
                {
                    $payment_meta = $request->only('mobileBankingType', 'mobileBankingAccountNumber', 'mobileBankingTransactionNumber');
                }
                elseif($request->paymentMethodId == 2)
                {
                    $payment_meta = $request->only('bankName', 'bankAccountNumber', 'bankBranchName');
                }
                elseif($request->paymentMethodId == 3)
                {
                    $payment_meta = $request->only('cardHolderName','cardNumber','cardExpiredDate','cardCvv');
                }
                elseif($request->paymentMethodId == 4)
                {
                    $payment_meta = $request->only('paypalEmail','paypalAmount');
                }
                elseif($request->paymentMethodId == 5)
                {
                    $payment_meta = $request->only('cashOnDeliveryAmount');
                }

                $paymentDetails->payment_meta = json_encode($payment_meta);

                $paymentDetails->save();

            });

        } catch (QueryException $e) {

            return response()->json(['errors' => $e->getMessage()]);
        }

        return response()->json(['success' => 'Order Placed Successfully']);
    }

    private function _generateRandomOrderNumber(){

        $date = date("Ymd");
        $randomNumber = random_int(100000,999999);

        $uniqueNumber = $date.$randomNumber;

        return $uniqueNumber;
    }
}
