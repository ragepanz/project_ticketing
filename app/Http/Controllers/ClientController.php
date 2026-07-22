<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function login()
    {
        return view('client.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'client'])) {
            $request->session()->regenerate();
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function register()
    {
        return view('client.register');
    }

    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'client',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password'], 'role' => 'client'])) {
            $request->session()->regenerate();
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('client.login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $participants = Participant::with('event')
            ->where('email', $user->email)
            ->latest()
            ->get();

        return view('client.dashboard', compact('user', 'participants'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('peserta.index');
    }
}
