<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
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

     public function edit (User $user)
    {
        $user = User::find($user->id);
    }
public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500', 
        ]);

        // Update the User 
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Get the user's default address
        $defaultAddress = $user->defaultAddress;

        // Only update the address if one already exists
        if ($defaultAddress) {
            $defaultAddress->update([
                'phone' => $request->phone,
                'address_line' => $request->address,
            ]);
        }
        
        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }
}