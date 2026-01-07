<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\{Facades\Auth, Facades\DB, Facades\Storage, Str};
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookController extends Controller
{
    /* -----------------------------------------------------------------
     |  Admin authorisation helper
     | ----------------------------------------------------------------- */
    private function authorizeAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, __('messages.only_admins'));
        }
    }

    /* -----------------------------------------------------------------
     |  Display all books (with search)
     | ----------------------------------------------------------------- */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $books = Book::when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
                     ->latest()
                     ->get();

        return view('books.index', compact('books', 'search'));
    }

    /* -----------------------------------------------------------------
     |  Show upload form
     | ----------------------------------------------------------------- */
    public function create()
    {
        $this->authorizeAdmin();

        return view('books.create');
    }

    /* -----------------------------------------------------------------
     |  Store new book
     | ----------------------------------------------------------------- */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pdf'   => 'required|file|mimes:pdf|max:204800', // 200 MB
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $pdfPath = $request->file('pdf')->store('books', 'public');

            Book::create([
                'title'   => $validated['title'],
                'pdf'     => $pdfPath,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('books.index')
                             ->with('success', __('messages.book_uploaded'));
        });
    }

    /* -----------------------------------------------------------------
     |  Download PDF
     | ----------------------------------------------------------------- */
    public function download(Book $book): BinaryFileResponse|RedirectResponse
    {
        if (!Storage::disk('public')->exists($book->pdf)) {
            return redirect()->back()->with('error', __('messages.file_not_found'));
        }

        $safeName = Str::slug($book->title) . '.pdf';

        return response()->download(
            Storage::disk('public')->path($book->pdf),
            $safeName
        );
    }

    /* -----------------------------------------------------------------
     |  Delete book
     | ----------------------------------------------------------------- */
    public function destroy(Book $book): RedirectResponse
    {
        $this->authorizeAdmin();

        DB::transaction(function () use ($book) {
            if (Storage::disk('public')->exists($book->pdf)) {
                Storage::disk('public')->delete($book->pdf);
            }
            $book->delete();
        });

        return redirect()->route('books.index')
                         ->with('success', __('messages.book_deleted'));
    }
}