<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
  

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/timeline';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
  
    public function logout()
    {
      Auth::logout();
      return redirect('/');
    }
  
    public function showLoginForm()
    {
        return redirect()->route('twitter-login');
    }
   
  
      /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $twitter_user = Socialite::driver('twitter')->user();
        if (User::where('email', $twitter_user->email)->exists()) {
          $user = User::where('email', $twitter_user->email)->first();
          $user->token = $twitter_user->token;
          $user->secret = $twitter_user->tokenSecret;
          $user->save();
          Auth::loginUsingId($user->id);
          return redirect()->route('timeline');
        }
      
        $user = new User;
        $user->email = $twitter_user->email;
        $user->name = $twitter_user->name;
        $user->token = $twitter_user->token;
        $user->secret = $twitter_user->tokenSecret;  
        $user->save();
        
        Auth::loginUsingId($user->id);
      
        return redirect()->route('timeline');

    }
}


