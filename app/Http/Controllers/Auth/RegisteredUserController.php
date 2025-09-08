<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Menambahkan aturan 'unique' agar tidak ada nama owner yang sama
            'name' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // DIUBAH: Menambahkan usertype 'owner' dan cabang_id null secara otomatis
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'usertype' => 'owner',      // <-- KUNCI UTAMA
            'cabang_id' => null,        // Owner tidak terikat pada cabang manapun
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('owner.dashboard'));
    }
}