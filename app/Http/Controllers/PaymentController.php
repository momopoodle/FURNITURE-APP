<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Payments;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Html;

class PaymentController extends Controller
{
    public function show($paymentGateway)
    {
        //dd('payment page');
        if(!session()->has('orderId')){
            return redirect('home');
        }

        $order= Orders::where('tracking_id',session('orderId'))->first();

        
        if($paymentGateway=="COD"){
            return view('payments.cod');
        }
        if($paymentGateway=="khalti"){

            $parameters=[
                'return_url'=>route('thankyou'),
                'website_url'=>config('app.url'),
                'amount'=>$order->total,
                'purchase_order_id'=>$order->tracking_id,
                'purchase_order_name'=>"ECOMMERCE ORDER". $order->tracking_id,
            ];
           $response= Http::withHeaders([
                'Authorization'=>'Key '. config('khalti.live_secret_key')
            ])->post(config('khalti.base_url').'/epayment/initiate/', $parameters);

            //dd($response->json());

            if($response->failed()){
                dd('payment with khalti failed');
            }
            $data= $response->json();
            return redirect($data['payment_url']);
        }
    }

    public function thankyou(Request $request)
    {
        $data= $request->all();
     
       // dd('thankyou');
       $order= Orders::where('tracking_id',$data['purchase_order_id'])->firstOrFail();
       $orderPayment= $order->payment()->update([
        'payment_status'=>'PAID',
        'price_paid'=> $data['amount'],
        'transaction_id'=>$data['transaction_id']
       ]);
       return view('thankyou');
    //dd($orderPayment);

    }
}
