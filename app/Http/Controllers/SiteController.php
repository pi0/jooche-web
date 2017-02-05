<?php

namespace App\Http\Controllers;

use App\Category;
use App\Offer;
use App\Topic;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use MongoDB\BSON\ObjectID;
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

        // topics
        Route::get('/dashboard/topics', 'SiteController@topics')->name('dashboard.topics');
        Route::put('/dashboard/topics', 'SiteController@topicsPut');
        Route::delete('/dashboard/topics/{topic}', 'SiteController@topicsDelete');
        Route::post('/dashboard/topics/{topic}', 'SiteController@topicsPost');

        // categories
        Route::get('/dashboard/categories', 'SiteController@categories')->name('dashboard.categories');
        Route::put('/dashboard/categories', 'SiteController@categoriesPut');
        Route::delete('/dashboard/categories/{category}', 'SiteController@categoriesDelete');
        Route::post('/dashboard/categories/{category}', 'SiteController@categoriesPost');

        // offers
        Route::get('/dashboard/offers', 'SiteController@offers')->name('dashboard.offers');
        Route::put('/dashboard/offers', 'SiteController@offersPut');
        Route::delete('/dashboard/offers/{offer}', 'SiteController@offersDelete');
        Route::post('/dashboard/offers/{offers}', 'SiteController@offersPost');


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
        $topics = Topic::all();
        $chart = [];
        foreach ($topics as $topic) {
            $chart[$topic->name] = $topic->categories->count();
        }

        return view('dashboard.overview', compact('chart'));
    }

    // --------------------------------------------------------------
    // Dashboard::Interests
    // --------------------------------------------------------------

    public function topics()
    {
        if ($this->request->wantsJson()) {
            $topics = Topic::all();
            return $topics;
        }

        return view('dashboard.topics');
    }

    public function topicsPut()
    {
        $topic = new Topic();
        $topic->name = 'بدون عنوان';
        $topic->save();
    }

    public function topicsDelete(Topic $topic)
    {
        $topic->delete();
    }

    public function topicsPost(Topic $topic)
    {
        $topic->name = $this->request->name;
        $topic->save();

        $img = Image::make($this->request->image);
        $img->save('storage/topic/' . $topic->id . '.jpg');
    }

    // --------------------------------------------------------------
    // Dashboard::Offers
    // --------------------------------------------------------------

    public function offers()
    {
        if ($this->request->wantsJson()) {
            $offers = Offer::all();
            return $offers;
        }

        return view('dashboard.offers');
    }

    public function offersPut()
    {
        $offer = new Offer();
        $offer->name = 'بدون عنوان';
        $offer->save();
    }

    public function offersDelete(Offer $offer)
    {
        $offer->delete();
    }

    public function offersPost(Offer $offer)
    {
        $offer->name = $this->request->name;
        $offer->topic_id = new ObjectId($this->request->topic_id);
        $offer->save();

        $img = Image::make($this->request->image);
        $img->save('storage/offer/' . $offer->id . '.jpg');
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
        $category = new Category();
        $category->name = 'عنوان دسته بندی';
        $category->save();
    }

    public function categoriesDelete(Category $category)
    {
        $category->delete();
    }

    public function categoriesPost(Category $category)
    {
        $category->name = $this->request->name;
        $category->topic_id = new ObjectId($this->request->topic_id);
        $category->tags = explode(' ', $this->request->tags);
        $category->save();

        $img = Image::make($this->request->image);
        $img->save('storage/category/' . $category->id . '.jpg');
    }

}
