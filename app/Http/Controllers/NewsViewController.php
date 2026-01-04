<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsViewController extends Controller
{
    /**
     * Show single news by ID.
     */
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    /**
     * Display all breaking news.
     */
    public function breaking()
    {
        $newsItems = News::where('type', 'breaking')->latest()->get();
        return view('news.index', [
            'newsItems' => $newsItems,
            'title' => 'Breaking News'
        ]);
    }

    /**
     * Display all news of the day.
     */
    public function day()
    {
        $newsItems = News::where('type', 'day')->latest()->get();
        return view('news.index', [
            'newsItems' => $newsItems,
            'title' => 'News of the Day'
        ]);
    }

    /**
     * Display all news of the week.
     */
    public function week()
    {
        $newsItems = News::where('type', 'week')->latest()->get();
        return view('news.index', [
            'newsItems' => $newsItems,
            'title' => 'News of the Week'
        ]);
    }
}
