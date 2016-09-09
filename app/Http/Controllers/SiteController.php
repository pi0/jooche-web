<?php

namespace App\Http\Controllers;

use App\Category;
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
        // Welcome Page
        Route::get('/', 'SiteController@welcome')->name('welcome');

        // Overview
        Route::get('/dashboard', 'SiteController@overview')->name('dashboard.overview');

        // interests
        Route::get('/dashboard/interests', 'SiteController@interests')->name('dashboard.interests');
        Route::put('/dashboard/interests', 'SiteController@interestsPut');
        Route::delete('/dashboard/interests/{interest}', 'SiteController@interestsDelete');
        Route::post('/dashboard/interests/{interest}', 'SiteController@interestsPost');

        // categories
        Route::get('/dashboard/categories', 'SiteController@categories')->name('dashboard.categories');
        Route::put('/dashboard/categories', 'SiteController@categoriesPut');
        Route::delete('/dashboard/categories/{category}', 'SiteController@categoriesDelete');
        Route::post('/dashboard/categories/{category}', 'SiteController@categoriesPost');

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
        if ($this->request->wantsJson()) {
            $interests = Interest::all();
            return $interests;
        }

        return view('dashboard.interests');
    }

    public function interestsPut()
    {
        $interest = new Interest();
        $interest->name = 'بدون عنوان';
        $interest->save();
    }

    public function interestsDelete(Interest $interest)
    {
        $interest->delete();
    }

    public function interestsPost(Interest $interest)
    {
        $interest->name=$this->request->name;
        $interest->image=$this->request->image;
        $interest->save();
    }



    // --------------------------------------------------------------
    // Dashboard::Categories
    // --------------------------------------------------------------

    public function categories()
    {
        if ($this->request->wantsJson()) {
            $categories = Category::all();
            return $categories;
        }
        return view('dashboard.categories');
    }


    public function categoriesPut()
    {
        $category=new Category();
        $category->name = 'بدون عنوان';
        $category->topic='پیش فرض';
        $category->save();
    }

    public function categoriesDelete(Category $category)
    {
        $category->delete();
    }

    public function categoriesPost(Category $category)
    {
        $category->name=$this->request->name;
        $category->topic=$this->request->topic;
        $category->tags=explode(' ',$this->request->tags);
        $category->image=$this->request->image;
        $category->save();
    }

}
