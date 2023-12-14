<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\order_items;
use App\Models\Orders;
use App\Models\PaymentGateways;
use App\Models\Payments;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class CheckoutController extends Controller
{
    public function show()
    {
        $shoppingCart=Cart::name('shopping');
        $items= $shoppingCart->getItems();
        $total=$shoppingCart->getTotal();
        $subtotal=$shoppingCart->getSubTotal();

         return view('checkout',[
             'items'=>$items,
             'total'=>$total,
             'subtotal'=>$subtotal

         ]);
    }

    public function store(Request $request)
    {
        $shoppingCart=Cart::name('shopping');
        $items= $shoppingCart->getItems();
        $total=$shoppingCart->getTotal();

        //dd($request->all());
        $data= $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required',
            'email'=>'required|email',
            'country'=>'required',
            'province'=>'required',
            'district'=>'required',
            'address'=>'required',
            'street_address'=>'required',
            'payment_gateway'=>'required',
            'zip'=>'required'

        ]);

       // dd($data);

       //create address
       $address= Address::create([
        'country'=>$data['country'],
        'province'=>$data['province'],
        'district'=>$data['district'],
        'street_address'=>$data['street_address'],
        'zipcode'=>$data['zip']
       ]);

       $paymentGateway= PaymentGateways::where('code',$data['payment_gateway'])->first();
       //create payment
       $payment= Payments::create([
        'payment_gateway_id'=>$paymentGateway->id,
        'payment_status'=>"Not_Paid",
        'price_paid'=>0
       ]);


       //create order
       $order= Orders::create([
        'tracking_id'=>"ORG-" . uniqid(),
        'total'=>$total*100,
        'full_name'=>$data['first_name' ]. "" .$data['last_name'],
        'email'=>$data['email'],
        'phone_number'=>$data['phone'],
        'billing_id'=>$address->id,
        'shipping_id'=>$address->id,
        'payment_id'=>$payment->id

       ]);

       foreach($items as $item)
       $OrderItems= order_items::create([
         'order_id'=>$order->id,
         'product_id'=>$item->getId(),
         'name'=>$item->getTitle(),
         'quantity'=>$item->getQuantity(),
         'price'=>$item->getPrice()*100
       ]);
    
   $shoppingCart->destroy();

   return redirect()->route('payment.show',['paymentGateway'=>$data['payment_gateway']])->with([
    'orderId'=>$order->tracking_id
   ]);

    }
}
