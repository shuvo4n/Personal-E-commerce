<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{

    public function index($coupon_name = ""){
            $error_message = "";
            $discount_amount = 0;
        if ($coupon_name == "") {
            $error_message = "";
            $coupon_value = "";
        } else {
            if (!Coupon::where('coupon_name', $coupon_name)->exists()) {
                $error_message = "Invalid Coupon";
                $coupon_value = "";
            }else {
                //This Query for coupon date
                Coupon::where('coupon_name', $coupon_name)->first()->validity_till;
                // check the current date
                Carbon::now()->format('Y-m-d');
                if (Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon_name)->first()->validity_till) {
                    $error_message = "Coupon Validity Expired";
                } else {
                    $sub_total = 0;
                    foreach (cart_items() as $cart_item) {
                        $cart_item->product_quantity;
                        $cart_item->product->product_price;
                        $sub_total += ($cart_item->product_quantity * $cart_item->product->product_price);
                    }
                    if (Coupon::where('coupon_name', $coupon_name)->first()->minimum_purchase_amount > $sub_total) {
                        $error_message = "You have to purchase minimum: ". Coupon::where('coupon_name', $coupon_name)->first()->minimum_purchase_amount;
                    } else {
                        $discount_amount = Coupon::where('coupon_name', $coupon_name)->first()->discount_amount;
                        $coupon_value = $coupon_name;
                    }

                }

            }
            # code...
        }
        return view('frontend.cart', compact('error_message', 'coupon_value', 'discount_amount' ));

    }

    public function store(Request $request){
      if (Cookie::get('g_cart_id')) {
             $generated_cart_id = Cookie::get('g_cart_id');
    }
    else{
          $generated_cart_id = Str::upper(str::random(3)).rand( 1, 1000);
          Cookie::queue('g_cart_id', $generated_cart_id, 1440);
      }
        If(Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->exists()){
            Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $request->product_id)->increment('product_quantity', $request->product_quantity);
        }
        else {
            Cart::insert([
                'generated_cart_id' => $generated_cart_id,
                'product_id' => $request->product_id,
                'product_quantity' => $request->product_quantity,
                'created_at' => Carbon::now()
            ]);
        }
    return back();
    }
    public function update(Request $request){

    foreach ($request->product_info as $cart_id => $product_quantity) {
        Cart::find($cart_id)->update([
            'product_quantity' => $product_quantity
        ]);
    }
    return back()->with('update_status', 'Your Cart Item Update successfully');
    }

    public function remove($cart_id){
        Cart::find($cart_id)->forceDelete();
        return back()->with('remove_status', 'Your Cart Item removed successfully');
    }
}
