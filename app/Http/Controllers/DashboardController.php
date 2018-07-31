<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Stuff;
use App\Person;
use App\Drop;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stuff_sum = DB::table('stuffs')
          ->sum('quantity');

        $drop_sum = DB::table('drops')
          ->sum('quantity');

        $stuff_date = [];
        $stuff_date[1] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subDay(1))
          ->sum('quantity');

        $stuff_date[2] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subDay(2))
          ->sum('quantity');

        $stuff_date[3] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subDay(3))
          ->sum('quantity');

        $stuff_date[4] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subDay(4))
          ->sum('quantity');

        $stuff_date[5] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subDay(5))
          ->sum('quantity');


        $stuff_date[6] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subDay(6))
          ->sum('quantity');

        $stuff_date['m1'] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subMonthsNoOverflow(1))
          ->sum('quantity');

        $stuff_date['m2'] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subMonthsNoOverflow(2))
          ->sum('quantity');

        $stuff_date['m3'] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subMonthsNoOverflow(3))
          ->sum('quantity');

        $stuff_date['m4'] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subMonthsNoOverflow(4))
          ->sum('quantity');

        $stuff_date['m5'] = DB::table('stuffs')
          ->where('created_at', '<=', \Carbon\Carbon::now()->subMonthsNoOverflow(5))
          ->sum('quantity');

        return view('dashboard.index')
          ->with('stuff_sum', $stuff_sum)
          ->with('drop_sum', $drop_sum)
          ->with('stuff_date', $stuff_date);
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
