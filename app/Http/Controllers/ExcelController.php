<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stuff;
use App\Drop;
use Carbon\Carbon;
use DB;

class ExcelController extends Controller
{
    public function stock($from, $to)
    {
        $stuff = DB::table('stuffs')
          ->select('stuffs.*')
          ->whereBetween('created_at', [$from, $to])
          ->get();
        dd($stuff);
    }

    public function stuff($from, $to)
    {
        $stuff = DB::table('stuffs')
          ->select('stuffs.*')
          ->whereBetween('created_at', [$from, $to])
          ->get();
        dd($stuff);
    }

    public function drop($from, $to)
    {
        $stuff = DB::table('stuffs')
          ->select('stuffs.*')
          ->whereBetween('created_at', [$from, $to])
          ->get();
        dd($stuff);
    }
}
