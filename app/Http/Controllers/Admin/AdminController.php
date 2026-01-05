<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        $books = Book::latest()->get();
        return view('admin.dashboard', compact('books'));
    }

    /**
     * Show all users (admin only)
     */
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Delete a user (except admin)
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        }

        return redirect()->back()->with('error', 'Cannot delete admin user.');
    }

    /**
     * Toggle user status (block / activate)
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            $user->blocked = !$user->blocked;
            $user->save();

            return redirect()->back()->with('success', 'User status updated successfully.');
        }

        return redirect()->back()->with('error', 'Cannot block/activate admin user.');
    }

    /**
     * Change user role
     */
    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'admin') {
            $request->validate([
                'role' => 'required|in:user,editor,moderator', // adjust roles as needed
            ]);

            $user->role = $request->role;
            $user->save();

            return redirect()->back()->with('success', 'User role updated successfully.');
        }

        return redirect()->back()->with('error', 'Cannot change role of admin user.');
    }

    /**
     * Store a new book (admin only)
     */
    public function storeBook(Request $request)
    {
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

        return redirect()->route('admin.dashboard')->with('success', 'Book uploaded successfully.');
    }

    /**
     * Delete a book (admin only)
     */
    public function destroyBook($id)
    {
        $book = Book::findOrFail($id);

        if (Storage::disk('public')->exists($book->pdf)) {
            Storage::disk('public')->delete($book->pdf);
        }

        $book->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Book deleted successfully.');
    }
}
