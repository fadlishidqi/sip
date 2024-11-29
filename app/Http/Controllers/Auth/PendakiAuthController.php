<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pendaki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PendakiAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.pendaki.login');
    }

    public function showRegisterForm()
    {
        return view('auth.pendaki.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('pendaki')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('pendaki.dashboard');
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:pendakis',
            'password' => 'required|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pendakis',
            'jenis_kelamin' => 'required|in:L,P',
            'umur' => 'required|integer|min:17',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'no_telp_darurat' => 'required|string|max:15',
            'hubungan_darurat' => 'required|string|max:255',
        ]);

        $pendaki = Pendaki::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'umur' => $validated['umur'],
            'alamat' => $validated['alamat'],
            'no_telp' => $validated['no_telp'],
            'no_telp_darurat' => $validated['no_telp_darurat'],
            'hubungan_darurat' => $validated['hubungan_darurat'],
        ]);

        Auth::guard('pendaki')->login($pendaki);

        return redirect()->route('pendaki.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('pendaki')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}