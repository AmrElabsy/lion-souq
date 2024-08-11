<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Cart;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\PaymentInfo;
use App\Models\Vendor;
use App\Notifications\OrderNotification;
use Srmklive\PayPal\Services\PayPal;


class OrderController extends Controller
{
    public function index()
    {
        if (isAdmin()) {
            $orders = Order::all();
        } else if (isVendor()) {
            $vendors = auth()->user()->vendors;
            $ids = $vendors->pluch('id')->toArray();
            $orders = Order::whereIn('id', $ids)->get();
        } else {
            $orders = auth()->user()->orders;
        }
        
        return new OrderCollection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $cart = Cart::findorFail($request->get("cart_id"));
    
        $credentials = [
            'mode'    => 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => env('PAYPAL_CLIENT_ID'),
                'client_secret'     => env('PAYPAL_SECRET_ID'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => env('PAYPAL_CURRENCY', 'USD'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.

        ];
        $provider = new PayPal($credentials);
    
        $provider->setApiCredentials($credentials);
        
        $paypaltoken = $provider->getAccessToken();
        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('payment.success', $cart->id),
                'cancel_url' => route('payment.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $cart->total
                    ]
                ]
            ]
        ]);
    
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('payment.cancel');
        }
    }

    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
    
    public function success(Cart $cart) {
        $products = $cart->products;
    
        $vendors = [];
        foreach ($products as $product) {
            if ( !isset( $vendors[$product->vendor_id] )) {
                $order = new Order();
                $order->vendor_id = $product->vendor_id;
                $order->user_id = $cart->user_id;
                $order->status = Order::PENDING;
                $order->total = 0;
                $order->save();
            
                $vendors[$product->vendor_id] = $order->id;
            } else {
                $order = Order::findorFail($vendors[$product->vendor_id]);
            }
            $order->products()->attach($product->id, ["amount" => 1]);
            $order->total = $order->total + $product->price;
            $order->save();
        }
    
        $cart->status = Cart::DONE;
        $cart->save();
    
        foreach ($vendors as $v => $o) {
            $vendor = Vendor::find($v);
            $orderObject = Order::find($o);
            $vendor->user->notify(new OrderNotification($orderObject));
        }
        
        $orders = Order::whereIn('id', $vendors)->get();
    
        return new OrderCollection($orders);
    }
    
    public function cancel() {
        return paymentFailed();
    }
}
