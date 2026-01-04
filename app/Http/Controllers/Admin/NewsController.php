<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display list of news by type
     */
    public function index($type)
    {
        $news = News::where('type', $type)->latest()->get();
        return view('admin.news.index', compact('news', 'type'));
    }

    /**
     * Show form to create news
     */
    public function create($type)
    {
        return view('admin.news.create', compact('type'));
    }

    /**
     * Store new news in database
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:breaking,day,week',
            'publish_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index', ['type' => $data['type']])
            ->with('success', 'News added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update news
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:breaking,day,week',
            'publish_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index', ['type' => $news->type])
            ->with('success', 'News updated successfully!');
    }

    /**
     * Delete news
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $type = $news->type;
        $news->delete();

        return redirect()->route('admin.news.index', ['type' => $type])
            ->with('success', 'News deleted successfully!');
    }


}

