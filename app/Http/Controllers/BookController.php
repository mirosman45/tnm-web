<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display all books with optional search.
     */
    public function index(Request $request)
    {
        $query = Book::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        $books = $query->latest()->get();
        $search = $request->search ?? '';
        
        return view('books.index', compact('books', 'search'));
    }

    /**
     * Show form to upload a book (admin only)
     */
    public function create()
    {
        // Check if user is authenticated and is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized: Only admins can upload books');
        }

        return view('books.create');
    }

    /**
     * Store book (admin only)
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized: Only admins can upload books');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        $pdfPath = $request->file('pdf')->store('books', 'public');

        Book::create([
            'title' => $request->title,
            'pdf' => $pdfPath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('books.index')->with('success', 'Book uploaded successfully.');
    }

    /**
     * Download book PDF
     */
    public function download($id)
    {
        $book = Book::findOrFail($id);

        if (!Storage::disk('public')->exists($book->pdf)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filename = pathinfo($book->pdf, PATHINFO_FILENAME) . '.pdf';
        return response()->download(Storage::disk('public')->path($book->pdf), $filename);
    }

    /**
     * Delete book (admin only)
     */
    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized: Only admins can delete books');
        }

        $book = Book::findOrFail($id);

        if (Storage::disk('public')->exists($book->pdf)) {
            Storage::disk('public')->delete($book->pdf);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
