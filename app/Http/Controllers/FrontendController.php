<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Contact;
use App\User;
use Carbon\Carbon;
use Hash;
use Auth;

class FrontendController extends Controller
{
    //

    function index(){
      return view('frontend.index', [
          'active_categories' => Category::all(),
          'active_products' => Product::all(),
      ]);
    }

    function productdetails($slug){
      //echo $slug;
      $product_info = Product::where('slug', $slug)->firstOrFail();
      $product_info->category_id;
      $related_products = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_info->id)->limit(4)->get();

      return view('frontend.productdetails', [
        'product_info' => $product_info,
        'related_products' => $related_products
      ]);
    }
    function contact(){
      return view('frontend.contact');
    }
    function contactinsert(Request $request){
      //print_r($request->except('_token'));
      //die();
      $contact_id = Contact::insertGetId($request->except('_token')+[
        'created_at' => Carbon::now()
      ]);
      if ($request->hasFile('contact_attachment')) {
        // $path = $request->file('contact_attachment')->store('contact_uploads');
        $path = $request->file('contact_attachment')->storeAs(
          'contact_uploads', $contact_id.".".$request->file('contact_attachment')->getClientOriginalExtension()
        );
        echo $path;
        Contact::find($contact_id)->update([
          'contact_attachment' => $path
        ]);
      }
      return back()->with('success_status', 'Messege Send successfull');
    }

    function about(){
      return view('frontend.about');
    }
    function shop(){
      return view('frontend.shop',[
        'categories' => Category::all(),
        'products' => Product::all()
      ]);
    }
    function customerregister(){
      return view('frontend.customerregister',[
        'categories' => Category::all(),
        'products' => Product::all()
      ]);
    }
    function customerregisterpost(Request $request){
      User::insert([
          'name' => $request->name,
          'email' => $request->email,
          'role' => 2,
          'password' => Hash::make($request->password),
          'created_at' => Carbon::now(),
      ]);
      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('customer/home');
      }
      return back();
    }

}
