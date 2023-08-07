<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function payment(Request $request){
        Stripe::setApiKey(config('stripe.sk'));
        $response = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'gimme money!!!!',//test data
                        ],
                        'unit_amount'  => $request->price * 100, // $40 = 4000 cents
                    ],
                    'quantity'   => 1,
                ],
            ],

            'mode'        => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url'  => route('stripe.cancel'),
        ]);

        return redirect()->away($response->url);
    }

    public function success(Request $request){
        //save transaction from $response to DB

        return 'Payment Is Successful!';
    }

    public function cancel(){
        //Return to purchase page with error message

        return 'Payment Is UnSuccessful!';
    }
}
