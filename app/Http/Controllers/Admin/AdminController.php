<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        return view('admin.dashboard');
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
}
