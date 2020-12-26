<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon\carbon;
use Hash;
use Image;
use Mail;
use App\Mail\ChangePasswordMail;


class ProfileController extends Controller
{
    //
    function profile()
    {
      return view('admin.profile.index');
    }
    function editprofilepost(Request $request)
    {
      //echo Auth::user()->id;
      //echo $request->name;
      //echo Auth::user()->updated_at->addDays(30);
      //echo Carbon::now();
      $request->validate([
        'name' => 'required'
      ]);
      if (Auth::user()->updated_at->addDays(30) < Carbon::now()) {
        User::find(Auth::id())->update([
          'name' => $request->name
        ]);
        return back()->with('name_change_status','Your Name Updated successfully');
      }else {
        $left_days = Carbon::now()->diffInHours(Auth::user()->updated_at->addDays(30));
        return back()->with('name_error','You Can Change Your Name '.$left_days. ' Hours');
      }
    }
    function editpasswordpost(Request $request)
    {
      //echo $request->old_password;
      //echo Auth::user()->password;
      $request->validate([
        'password' => 'confirmed|min:8|alpha_num'
      ]);
      if (Hash::check($request->old_password, Auth::user()->password)) {
        if ($request->old_password == $request->new_password) {
          return back()->with('password_error', 'You Used Same Again');
        }else {
          //echo Hash:make($request->password);
          User::find(Auth::id())->update([
            'password' => Hash::make($request->password)
          ]);
          //send a password change notification mail
          Mail::to(Auth::user()->email)->send(new ChangePasswordMail(Auth::user()->name));
          return back();
        }
      }else {
        return back()->with('password_error', 'Your Password Not matched');
      }
    }
    function changeprofilephoto(Request $request){
        //print_r($request->profile_photo);
        $request->validate([
            'profile_photo' => 'required|image'
        ]);
        if($request->hasFile('profile_photo')){
            //echo Auth::id();
            //echo Auth::user()->profile_photo;
            if(Auth::user()->profile_photo != 'default.png'){
                //echo "Default png bete nai";
                //Delete old photo now.
                $old_photo_location = 'public/uploads/profile_photos/'.Auth::user()->profile_photo;
                //delete loction function
                unlink(base_path($old_photo_location));
            }
                //Die for test up codes.
                //die();
            $uploded_photo = $request->file('profile_photo');
            $new_photo_name = Auth::id().".".$uploded_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/profile_photos/'.$new_photo_name;
            Image::make($uploded_photo)->resize(500, 500)->save(base_path($new_photo_location));
            User::find(Auth::id())->update([
                'profile_photo' => $new_photo_name
            ]);

            return back();
        }else {
            echo "nai";
        }

    }
}
