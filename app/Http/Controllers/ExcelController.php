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
    public function stuff($from, $to, $format)
    {
        $GLOBALS['stuffs'] = DB::table('stuffs')
          ->join('categories', 'stuffs.category_id' , '=', 'categories.id')
          ->select('stuffs.*', 'categories.name as category')
          ->whereBetween('stuffs.created_at', [$from, $to])
          ->orderBy('stuffs.created_at', 'DESC')
          ->get();

        foreach ($GLOBALS['stuffs'] as $a) {
          $drops = Drop::get()->where('stuff_id', '=', $a->id);

          foreach ($drops as $b) {
            $a->quantity = $a->quantity + $b->quantity;
          }
        }

        Excel::create('Barang_Masuk-' . $from . ' to ' . $to, function ($excel) {
          $excel->sheet('stuff', function ($sheet) {
            $sheet->loadView('excels.stuff')
              ->with('stuffs', $GLOBALS['stuffs']);
          });
        })->download($format);
    }

    public function stock($from, $to, $format)
    {
        $GLOBALS['stocks'] = DB::table('stuffs')
          ->join('categories', 'categories.id', '=', 'stuffs.category_id')
          ->select('stuffs.*', 'categories.name as category')
          ->whereBetween('stuffs.created_at', [$from, $to])
          ->orderBy('stuffs.created_at', 'ASC')
          ->get();

        Excel::create('Stok-' . $from . ' to ' . $to, function ($excel) {
          $excel->sheet('stock', function ($sheet) {
            $sheet->loadView('excels.stock')
              ->with('stocks', $GLOBALS['stocks']);
          });
        })->download($format);
    }

    public function drop($from, $to, $format)
    {
        $GLOBALS['drops'] = DB::table('drops')
          ->join('stuffs', 'stuffs.id', '=', 'drops.stuff_id')
          ->join('categories', 'stuffs.category_id', '=', 'categories.id')
          ->select('drops.*', 'stuffs.name as stuff_name', 'categories.name as category')
          ->whereBetween('drops.created_at', [$from, $to])
          ->orderBy('drops.created_at', 'ASC')
          ->get();

        Excel::create('Barang_Keluar-' . $from . ' to ' . $to, function ($excel) {
          $excel->sheet('drop', function ($sheet) {
            $sheet->loadView('excels.drop')
              ->with('drops', $GLOBALS['drops']);
          });
        })->download($format);
    }
}
