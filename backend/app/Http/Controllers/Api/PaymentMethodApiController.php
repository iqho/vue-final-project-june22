<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;

class PaymentMethodApiController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::where('is_active', true)
                                        ->get(['id', 'name']);
        
        return response()->json([
            'paymentMethods' => $paymentMethods
        ], 200);
    }
}
