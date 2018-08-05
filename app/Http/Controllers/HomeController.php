<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Abraham\TwitterOAuth\TwitterOAuth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $current_user = Auth::user();
      $connection = new TwitterOAuth(env('TWITTER_CLIENT_ID'), env('TWITTER_CLIENT_SECRET'), $current_user->token, $current_user->secret);
      $content = $connection->get("statuses/home_timeline", ["count" => 200, "exclude_replies" => true]);
      if (gettype($content) == 'object') {
        if (isset($content->errors)) {
          if ($content->errors[0]->code == 88) {
            return view('timeline', ['tweets' => [], 'errors' => ["Twitter limits the number of tweets I can show you in a 15 minute period. It looks like we've reached that limit. Please come again soon!"]]);
          }
        }
      }
      return view('timeline', ['tweets' => $content]);
    }
}
