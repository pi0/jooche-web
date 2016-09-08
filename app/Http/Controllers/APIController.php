<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class APIController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public static function routes()
    {
        Route::get('test', 'ApiController@test');


    }

    public function test()
    {
        return ['foo'=>'bar'];
    }



}
