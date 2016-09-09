<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Http\Request;
use Route;

class SiteController extends Controller
{

    var $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => [
            'welcome'
        ]]);
        $this->request = $request;
    }

    // --------------------------------------------------------------
    // Routes
    // --------------------------------------------------------------

    public static function routes()
    {
        Route::get('/', 'SiteController@welcome')->name('welcome');

        // overview
        Route::get('/dashboard', 'SiteController@overview')->name('dashboard.overview');

        // interests
        Route::get('/dashboard/interests', 'SiteController@interests')->name('dashboard.interests');

        // categories
        Route::get('/dashboard/categories', 'SiteController@categories')->name('dashboard.categories');

    }

    // --------------------------------------------------------------
    // Welcome
    // --------------------------------------------------------------

    public function welcome()
    {
        return view('welcome');
    }

    // --------------------------------------------------------------
    // Dashboard::Overview
    // --------------------------------------------------------------

    public function overview()
    {
        return view('dashboard.overview');
    }

    // --------------------------------------------------------------
    // Dashboard::Interests
    // --------------------------------------------------------------

    public function interests()
    {
        $interests = Interest::all();

        return view('dashboard.interests', compact(['interests']));

    }

    // --------------------------------------------------------------
    // Dashboard::Categories
    // --------------------------------------------------------------

    public function categories()
    {
        return view('dashboard.categories');
    }

}
