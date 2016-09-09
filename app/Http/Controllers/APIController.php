<?php

namespace App\Http\Controllers;

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
        // TODO: List All Available Interests And Merge With Enabled Flag Based On Current User

        return [
            [
                '_id' => '29fba1333aab',
                'name' => 'موبایل و تبلت',
                'image' => 'http://icon73',
                'enabled' => true,
            ],
            [
                '_id' => '29fba1333aab',
                'name' => 'سلامت و زیبایی',
                'image' => 'http://icon73',
                'enabled' => true,
            ],

        ];
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
        return [
            [
                'name' => 'ابزار کامپیوتر',
                'items' => [
                    [
                        'cat_id' => '123',
                        'name' => 'موس و کی بورد',
                        'tags' => ['آبی', 'سبز'],
                    ]
                ]
            ]
        ];
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
