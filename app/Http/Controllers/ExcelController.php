<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stuff;
use App\Drop;
use Carbon\Carbon;
use DB;
use Excel;

class ExcelController extends Controller
{
    public function stock($from, $to)
    {
        $stuff = DB::table('stuffs')
          ->join('drops', 'stuffs.id' , '=', 'drops.stuff_id')
          ->select('stuffs.*', 'drops.quantity as drop_quantity')
          ->whereBetween('stuffs.created_at', [$from, $to])
          ->get();
        dd($stuff);
    }

    public function stuff($from, $to)
    {
        $GLOBALS['stuffs'] = DB::table('stuffs')
          ->join('categories', 'categories.id', '=', 'stuffs.category_id')
          ->select('stuffs.*', 'categories.name as category')
          ->whereBetween('stuffs.created_at', [$from, $to])
          ->orderBy('stuffs.created_at', 'ASC')
          ->get();

        Excel::create('Stuff-' . $from . ' to ' . $to, function ($excel) {
          $excel->sheet('stuff', function ($sheet) {
            $sheet->loadView('excels.stuff')
              ->with('stuffs', $GLOBALS['stuffs']);
          });
        })->download('xlsx');
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
