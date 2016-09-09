<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interest;
use App\Shop;
use App\Topic;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Route;
use Validator;

class APIController extends Controller
{

    var $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api', ['except' => ['auth']]);
        $this->request = $request;
    }

    // --------------------------------------------------------------
    // Routes
    // --------------------------------------------------------------

    public static function routes()
    {
        // Offers
        Route::get('offers/{type}', 'ApiController@offers');

        // Topics
        Route::get('topics', 'ApiController@topics');
        Route::post('topics', 'ApiController@topicsPost');

        // Wishes
        Route::post('wish', 'ApiController@wishPost');

        // Categories
        Route::get('categories/{topic}', 'ApiController@categories');

        // Location
        Route::get('location/set/{sat}/{long}', 'ApiController@locationSet');

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
        /** @var User $user */
        $user = Auth::user();

        foreach ($user->interests as $interest){

        }

        return Shop::all();
    }

    // --------------------------------------------------------------
    // Interests
    // --------------------------------------------------------------

    public function topics()
    {
        $interests= Topic::all();
        $user = Auth::user();
        $ids=$user->topic_ids?:[];
        foreach ($interests as &$interest){
            $interest['enabled']=in_array($interest->id,$ids);
        }

        return $interests;
    }

    public function interestsPost()
    {
        $user = Auth::user();

        $push=$this->request->json('push',[]);
        foreach ($push as $id)
            $user->push('topic_ids',$push,true);

        $pull=$this->request->json('pull',[]);
        foreach ($pull as $id)
            $user->pull('topic_ids',$pull);
    }

    // --------------------------------------------------------------
    // Categories
    // --------------------------------------------------------------

    public function categories(Topic $topic)
    {
        return $topic->categories;
    }


    // --------------------------------------------------------------
    // Location
    // --------------------------------------------------------------

    public function locationSet($lat, $long)
    {
        $user = Auth::user();
        $user->setAttribute('location', ['type' => "Point", 'coordinates' => [$lat,$long]]);
        $user->save();
        return $user;
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

        if (!$user) {
            // First Login
            $user = new User();
            $user->email = $credentials['email'];
            $user->password = Hash::make($credentials['password']);
            $user->first_login = true;
        } else {
            if (!Hash::check($credentials['password'], $user->password))
                return ['error' => 'credentials error', 'code' => 500];
            if ($user->first_login) {
                $user->first_login = false;
            }
        }

        $user->save();
        return $user->token;
    }

}
