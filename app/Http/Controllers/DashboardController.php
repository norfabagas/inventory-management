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
        return view('dashboard.stuff');
    }

    public function category()
    {
        return view('dashboard.category');
    }
}
