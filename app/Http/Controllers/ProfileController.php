<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\UserAddress;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // 1. Ambil data alamat user yang sedang login dan kirim ke view
        $addresses = $request->user()->addresses()->orderBy('is_default', 'desc')->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'addresses' => $addresses, // KIRIM DATA ALAMAT
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function storeAddress(Request $request): RedirectResponse
    {
        // 1. VALIDASI DATA
        // Hapus validasi 'phone' karena akan diambil dari user yang login.
        $validatedData = $request->validate([
            'recipient_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:255'],  
            'label' => ['required', 'string', 'max:50'],
            'address_line' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
            'country' => ['required', 'string', 'max:100'],
            'is_default' => ['nullable'],
        ]);

        $user = $request->user();

        // 2. BERI NILAI DEFAULT UNTUK 'recipient_name' dan 'phone'

        // Default untuk recipient_name
        if (empty($validatedData['recipient_name'])) {
            $validatedData['recipient_name'] = $user->name;
        }


        // 3. TANGANI CHECKBOX 'is_default'
        $isDefault = $request->has('is_default');

        // 4. LOGIKA UNTUK ALAMAT UTAMA (DEFAULT)
        if ($isDefault) {
            UserAddress::where('user_id', $user->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        // 5. SIAPKAN DATA AKHIR
        $dataToStore = array_merge($validatedData, [
            'user_id' => $user->id,
            'is_default' => $isDefault,
        ]);

        // 6. SIMPAN KE DATABASE
        $user->addresses()->create($dataToStore);

        return Redirect::route('profile.edit')->with('status', 'Alamat baru berhasil disimpan!');
    }
    public function destroyAddress(UserAddress $address): RedirectResponse
    {
        // Pastikan alamat yang akan dihapus dimiliki oleh user yang sedang login
        if (Auth::id() !== $address->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus alamat ini.');
        }

        // Jika alamat yang dihapus adalah alamat default, kita harus menangani kasus ini.
        if ($address->is_default) {
            // Opsional: Coba set alamat lain sebagai default, atau kirim error.
            // Untuk kesederhanaan, kita akan set alamat lain menjadi default jika ada.
            $nextDefault = UserAddress::where('user_id', Auth::id())
                ->where('id', '!=', $address->id)
                ->first();

            if ($nextDefault) {
                $nextDefault->update(['is_default' => true]);
            }
        }

        $address->delete();

        return Redirect::route('profile.edit')->with('status', 'Alamat berhasil dihapus.');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
