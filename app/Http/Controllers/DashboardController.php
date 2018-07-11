<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
