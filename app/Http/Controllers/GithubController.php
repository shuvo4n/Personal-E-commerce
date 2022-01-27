<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        //print_r($user);
        // $user->token;
        if (!User::where('email', $user->getEmail())->exists()) {
            User::insert([
                'name' => $user->getNickname(),
                'email' => $user->getEmail(),
                'role' => 2,
                'password' => Hash::make('Abc@123'),
                'created_at' => Carbon::now()
            ]);
        }
        if(Auth::attempt(['email' => $user->getEmail(), 'password' => 'Abc@123'])){
              return redirect('customer/home');
        }
    }
}
