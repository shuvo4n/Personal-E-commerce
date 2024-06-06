<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryForm;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Auth;
use Image;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    function addcategory(){
        return view('admin.category.index', [
          'categories' => Category::all(),
          'deleted_categories' => Category::onlyTrashed()->get()
        ]);
    }
    function addcategorypost(CategoryForm $request){
        //echo Auth::user()->id;
        $category_id = Category::insertGetId([
          'category_name' =>  $request->category_name,
          'category_description'  =>  $request->category_description,
          'user_id'  =>  Auth::id(),
          'created_at'  =>  Carbon::now(),
        ]);
        if ($request->hasFile('category_photo')) {
            // code...
            echo $category_id;
            //uploads category photos
            $uploded_photo = $request->file('category_photo');
            $new_photo_name = $category_id.".".$uploded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/category_photos/'.$new_photo_name;
            Image::make($uploded_photo)->resize(500, 500)->save(base_path($new_photo_location));
            Category::find($category_id)->update([
                'category_photo' => $new_photo_name
            ]);
            //return back(); //profile photo's copied return back.
        }
        //echo $request->category_name;
        //echo $request->category_description;
        return back()->with('success_status', $request->product_name.' Category added Successfully');
    }
    function deletecategory($category_id){
      //echo $category_id;
      //category delete
      Category::find($category_id)->delete();
      //then product delete
      Product::where('category_id', $category_id)->delete();
      return back()->with('delete_status', 'Your category deleted successfully');

    }
    function editcategory($category_id){
      //echo $category_id;
      return view('admin.category.edit', [
        'category_info' => Category::find($category_id)
      ]);
    }
    function editcategorypost(Request $request){
    $request->validate([
      'category_name'  =>  'unique:categories,category_name,'.$request->category_id
    ]);
    // $request->category_name
    // $request->category_description
    //Category::where('category_name', '=', '$request->category_name')->update([
    Category::find($request->category_id)->update([
      'category_name'  =>  $request->category_name,
      'category_description'  =>  $request->category_description
    ]);
    //return back()->with('edit_status', 'Your category edited successfully');
    return redirect('add/category')->with('edit_status', 'Your category edited successfully');
    }
    function restorecategory($category_id){
      //echo $category_id;
      Category::withTrashed()->find($category_id)->restore();
      return back()->with('restore_status', 'Your category restore successfully');

    }
    function forcedeletecategory($category_id){
      //echo $category_id;
      Category::withTrashed()->find($category_id)->forceDelete();
      return back()->with('force_delete_status', 'Your category Parmannently Deleted successfully');

    }
    function markdelete(Request $request){
      //print_r($request->all());
      if (isset($request->category_id)) {
        // code...
        foreach ($request->category_id as $catid) {
          Category::find($catid)->delete();
        }
        return back()->with('delete_status', 'Your category deleted successfully');
      }
      return back()->with('delete_status', 'No data Selected');
    }
    function markrestore(Request $request){
          print_r($request->all());
      if (isset($request->category_id)) {
        // code...
        foreach ($request->category_id as $catid) {
          Category::withTrashed()->find($catid)->restore();
        }
        return back()->with('restore_status', 'Your category restore successfully');
      }
      return back()->with('restore_status', 'No data Selected');
      }
}
