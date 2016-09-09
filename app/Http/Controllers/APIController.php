<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interest;
use Illuminate\Http\Request;
use Route;

class APIController extends Controller
{

    var $request;

    public function __construct(Request $request)
    {
        //$this->middleware('auth:api');
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
        Route::post('auth', 'ApiController@auth');

    }

    // --------------------------------------------------------------
    // Offers
    // --------------------------------------------------------------

    public function offers($type)
    {

        // TODO: Get Offers Based On User::wishes
        // OR
        // TODO: Get Offers Based On User::interests
        return [

            [
                'interest_id' => '123abc',
                'name' => 'ماشین',
                'items' => [
                    [
                        'offer_id' => '',
                        'name' => '',
                        'image' => '',
                    ]
                ]
            ]


        ];
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
        return Category::all();
    }


    // --------------------------------------------------------------
    // Location
    // --------------------------------------------------------------

    public function locationSet($lat, $long)
    {
        // TODO:  update user location
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
        // TODO
    }

}
