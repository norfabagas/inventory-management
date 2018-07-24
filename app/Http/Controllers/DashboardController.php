<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Stuff;
use App\Person;
use App\Drop;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function stuff()
    {
        $category = \App\Category::get();
        return view('dashboard.stuff')
          ->with('category', $category);
    }

    public function category()
    {
        return view('dashboard.category');
    }

    public function drop()
    {
        $stuff = Stuff::get();
        // $person = Person::get();

        return view('dashboard.drop')
          ->with('stuff', $stuff);
          // ->with('person', $person);
    }

    public function person()
    {
        return view('dashboard.person');
    }

    public function user()
    {
        return view('dashboard.user');
    }

    public function excel()
    {
        $oldest_stuff = Stuff::orderBy('created_at', 'ASC')->first();
        $newest_stuff = Stuff::orderBy('created_at', 'DESC')->first();
        $oldest = $oldest_stuff->created_at;
        $newest = $newest_stuff->created_at;

        return view('dashboard.excel')
          ->with('oldest', $oldest)
          ->with('newest', $newest);
    }
}
