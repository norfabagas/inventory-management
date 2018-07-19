<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Stuff;
use App\Person;
use App\Drop;

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
}
