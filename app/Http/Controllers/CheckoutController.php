<?php

namespace App\Http\Controllers;

use App\Billing;
use App\City;
use App\Country;
use App\Order;
use App\Shipping;
use App\User;
Use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('frontend.checkout',[
            'user' => User::find(Auth::id()),
            'countries' => Country::all()
        ]);
    }

    public function getcitylistajax(Request $request){

       //echo City::where('country_id',$request->country_id)->pluck('name', 'id');.
       $stringToSend = "";
       foreach (City::where('country_id',$request->country_id)->pluck('id', 'name') as $city => $city_id) {
           //echo "{$city}=>{$city_id}"."<br>";
           $stringToSend .= "<option value='". $city_id ."'>". $city ."</option>" ;
       }
       return  $stringToSend;
    }

    public function checkoutpost(Request $request){
         //die();
        //print_r($request->all());
        if (isset($request->shipping_address_status)) {
            $shipping_id = Shipping::insertGetId([
                'name' => $request->shipping_name,
                'email' => $request->shipping_email,
                'phone_no' => $request->shipping_phone_no,
                'country_id' => $request->shipping_country_id,
                'city_id' => $request->shipping_city_id,
                'address' => $request->shipping_address,
                'created_at' => Carbon::now(),
            ]);
        }else{
            $shipping_id = Shipping::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'created_at' => Carbon::now(),
            ]);

        }
        $billing_id = Billing::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'notes' => $request->notes,
            'created_at' => Carbon::now(),
        ]);
        Order::insert([
            'user_id'=> Auth::id(),
            'sub_total'=> session('cart_sub_total'),
            'discount_amount'=> session('discount_amount') ,
            'coupon_name'=> session('coupon_name') ,
            'total'=> (session('cart_sub_total') - session('discount_amount')) ,
            'payment_option'=> $request->payment_option ,
            'billing_id'=> $billing_id,
            'shipping_id'=> $shipping_id,
            'created_at' => Carbon::now(),
        ]);
    }
}
