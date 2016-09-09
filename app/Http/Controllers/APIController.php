<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interest;
use App\Shop;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Route;
use Validator;

class APIController extends Controller
{

    var $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api',['except'=>['auth']]);
        $this->request = $request;
    }

    // --------------------------------------------------------------
    // Routes
    // --------------------------------------------------------------

    public static function routes()
    {
        // Offers
        Route::get('offer/{type}', 'ApiController@offers');

        // Interests
        Route::get('interests', 'ApiController@interests');
        Route::post('interests', 'ApiController@interestsPost');

        // Wishes
        Route::post('wish', 'ApiController@wishPost');

        // Categories
        Route::get('categories', 'ApiController@categories');

        // Location
        Route::get('location/set/:sat/:long', 'ApiController@locationSet');

        // Profile
        Route::get('profile', 'ApiController@profile');
        Route::post('profile', 'ApiController@profilePost');

        // Auth
        Route::any('auth', 'ApiController@auth')->name('auth');

    }

    // --------------------------------------------------------------
    // Offers
    // --------------------------------------------------------------

    public function offers($type)
    {

        // TODO: Get Offers Based On User::wishes
        // OR
        // TODO: Get Offers Based On User::interests

        return Shop::all()->get();

    }

    // --------------------------------------------------------------
    // Interests
    // --------------------------------------------------------------

    public function interests()
    {
        return Interest::all();
    }

    public function interestsPost()
    {
        // TODO: { push:[interest_ids], pull:[interest_ids] }
    }

    // --------------------------------------------------------------
    // Categories
    // --------------------------------------------------------------

    public function categories()
    {
        return Category::all()->get();
    }


    // --------------------------------------------------------------
    // Location
    // --------------------------------------------------------------

    public function locationSet($lat, $long)
    {
        // TODO:  update user location
        return ['set'];
    }

    // --------------------------------------------------------------
    // Profile
    // --------------------------------------------------------------

    public function profile()
    {
        // TODO: return user profile
    }


    public function profilePost()
    {
        // TODO: update user profile
    }

    // --------------------------------------------------------------
    // Auth
    // --------------------------------------------------------------

    public function auth()
    {
        // get login credentials
        $credentials = $this->request->all();

        // create validator
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) return ['error' => 'username & password are required!', 'code' => 500];

        /** @var \App\User $user */
        $user = User::where('email', $credentials['email'])->first();

        if (!$user){
            // First Login
            $user=new User();
            $user->email=$credentials['email'];
            $user->password=Hash::make($credentials['password']);
            $user->first_login=true;
        } else {
            if (!Hash::check($credentials['password'], $user->password))
                return ['error' => 'credentials error', 'code' => 500];
            if($user->first_login){
                $user->first_login=false;
            }
        }

        $user->save();
        return $user->token;
    }

}
