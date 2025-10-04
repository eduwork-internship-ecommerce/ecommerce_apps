<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start the query, eager loading the default address.
        $query = User::with('defaultAddress');

        // Apply search filter if present.
        // We use a closure here to group the WHERE clauses, searching by name OR email.
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Paginate the results and append the existing query string 
        // to ensure filters are not lost when changing pages.
        $users = $query->paginate(10)->appends($request->query());

        return view('admin.users.index', compact('users'));
    }

    public function destroy (User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
