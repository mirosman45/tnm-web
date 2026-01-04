<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $breaking = News::where('type', 'breaking')->latest()->first();
        $day = News::where('type', 'day')->latest()->take(3)->get();
        $week = News::where('type', 'week')->latest()->take(3)->get();

        return view('home', compact('breaking', 'day', 'week'));
    }
}
