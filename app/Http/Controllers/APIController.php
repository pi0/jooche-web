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

    public static function routes()
    {
        Route::get('test', 'ApiController@test');

        // Interests
        Route::get('interests', 'ApiController@interests');
        Route::post('interestsPost', 'ApiController@interestsPost');

        // Wish
        Route::get('wish', 'ApiController@wish');
        Route::get('wish/{cat_id}', 'ApiController@wishDetails');
        Route::post('wish', 'ApiController@wishPost');


        // Profile
        Route::get('profile', 'ApiController@profile');
        Route::post('profile', 'ApiController@profilePost');

        // auth
        Route::post('auth', 'ApiController@login');

        // location
        Route::get('location', 'ApiController@location');

        // Offers
        Route::get('offers', 'ApiController@offers');


    }

    public function interests()
    {

        return [

            [
                '_id' => '29fba1333aab',
                'name' => 'موبایل و تبلت',
                'icon' => 'http://icon73',
                'enabled' => true,
            ],
            [
                '_id' => '29fba1333aab',
                'name' => 'سلامت و زیبایی',
                'icon' => 'http://icon73',
                'enabled' => true,
            ],

        ];


    }

    public function feed()
    {
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

    public function wish()
    {
        return [
            [
                'name' => 'ابزار کامپیوتر',
                'items' => [
                    [
                        'cat_id' => '123',
                        'name' => 'موس و کی بورد',
                    ]
                ]

            ]
        ];
    }

    public function wishDetails($cadId)
    {
        return [
            'tags' => ['آبی', 'سبز'],
        ];
    }

    public function interestsPost()
    {

        return ['error' => 'implement me!'];

    }

    public function login()
    {

    }

    public function profile()
    {

    }

    public function offers()
    {

        return [
            [
                '_id' => 'foo',
                'name' => '',
                'image' => '',
            ],
            [
                '_id' => 'bar',
                'name' => '',
                'image' => '',
            ],
        ];

    }

    public function profilePost()
    {

    }

    public function location()
    {

    }

    public function test()
    {
        return ['foo' => 'bar'];
    }


}
