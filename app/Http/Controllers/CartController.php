<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
            $product= Product::find($request->product_id);
            //dd($product);
            $shoppingCart= Cart::name('shopping');
            $shoppingCart->addItem([
                'id'=>$product->id,
                'title'=>$product->name,
                'quantity'=>(int)$request->quantity,
                'price'=>$product->price/100
            ]);

            return back();
    }

    public function show()
    {
        $shoppingCart=Cart::name('shopping');
        $items= $shoppingCart->getItems();
        $total=$shoppingCart->getTotal();
        $subtotal=$shoppingCart->getSubTotal();

        
        
        return view('cart',[
            'items'=> $items,
            'total'=>$total,
            'subtotal'=>$subtotal
        ]);
    }

    public function delete(Request $request)
    {
         //dd($request->all());
         $hash= $request->itemHash;
         $shoppingCart=Cart::name('shopping');
         $shoppingCart->removeItem($hash);

         return back();
    }
}