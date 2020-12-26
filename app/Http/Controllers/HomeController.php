<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Mail\NewsLetter;
use App\Contact;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        //Framework Class::method
        //$users = User::all(); // collection
        //
        //$users = User::orderBy('id', 'desc')->get();
        //
        //$users = User::latest()->get();
        //
        $users = User::latest()->paginate(1);
        $next = User::simplePaginate(1);
        $total_users = User::count();
        //return view('home', compact('users', 'next', 'total_users'));
        return view('home', [
          'users' => $users,
          'next' => $next,
          'total_users' => $total_users,
          'contacts' => Contact::all()
        ]);
        //return view('home');
    }
    public function sendnewsletter()
    {
        //
        foreach (User::all()->pluck('email') as $email) {
            // code...
            Mail::to($email)->send(new NewsLetter());
        }
        return back();
    }
    public function contactuploaddownload($contact_id)
    {
        //
        return Storage::download(Contact::findOrFail($contact_id)->contact_attachment);      
    }
}
