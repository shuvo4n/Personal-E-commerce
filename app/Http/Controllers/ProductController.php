<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Image;
use App\Product_image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.product.index', [
          'active_categories' => Category::all(),
          'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //print_r($request->except('_token'));
        //
      $slug_link = Str::slug($request->product_name."_".Str::random(5));
      $product_id = Product::insertGetId($request->except('_token', 'product_thumbnail_photo', 'product_multiple_photo') + [
        'slug' => $slug_link,
        'created_at' => Carbon::now()
      ]);
      if ($request->hasFile('product_thumbnail_photo')) {
          // code...
          echo $product_id;
          //uploads category photos
          $uploded_photo = $request->file('product_thumbnail_photo');
          $new_photo_name = $product_id.".".$uploded_photo->getClientOriginalExtension();
          $new_photo_location = 'public/uploads/product_photos/'.$new_photo_name;
          Image::make($uploded_photo)->resize(600, 622)->save(base_path($new_photo_location));
          Product::find($product_id)->update([
              'product_thumbnail_photo' => $new_photo_name
          ]);
          //return back(); //profile photo's copied return back.
      }
      if ($request->hasFile('product_multiple_photo')) {
        $flag = 1;
        foreach ($request->file('product_multiple_photo') as $single_photo) {
          // code...
          echo $single_photo;
          //uploads category photos
          $uploded_photo = $single_photo;
          $new_photo_name = $product_id."-".$flag.".".$uploded_photo->getClientOriginalExtension();
          $new_photo_location = 'public/uploads/product_multiple_photo/'.$new_photo_name;
          Image::make($uploded_photo)->resize(600, 622)->save(base_path($new_photo_location));
          Product_image::insert([
            'product_id' => $product_id,
            'product_image_name' => $new_photo_name
          ]);
          $flag++;
        }

      }
      return back()->with('product_status', $request->product_name.' Category added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view('admin.product.edit', [
          'active_categories' => Category::all(),
          'product_info' => $product
        ]);
        //findorfail use
        // return view('admin.product.show', [
        //   'product_info' => Product::findorfail($id)
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product )
    {
        //for test purpose
        // print_r($request->except('_token', '_method'));
        // die();
        $product->update($request->except('_token', '_method'));
        return redirect('product')->with('product_edit_status', $request->product_name.' Your Product edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //for force delete
        // $product->ForceDelete();
        //for soft delete
        $product->delete();
        return back();
    }
    function markdelete(Request $request){
      print_r($request->product_id);
      die();
      if (isset($request->product_id)) {
        // code...
        foreach ($request->product_id as $productid) {
          Product::find($productid)->delete();
        }
        return back()->with('delete_status', 'Your Product deleted successfully');
      }
      return back()->with('delete_status', 'No data Selected');
    }
    function markrestore(Request $request){
          //print_r($request->all());
      if (isset($request->category_id)) {
        // code...
        foreach ($request->category_id as $catid) {
          Product::withTrashed()->find($catid)->restore();
        }
        return back()->with('restore_status', 'Your category restore successfully');
      }
      return back()->with('restore_status', 'No data Selected');
      }
}
