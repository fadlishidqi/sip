<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $pendaki = Auth::guard('pendaki')->user();
        return view('pendaki.profile.edit', compact('pendaki'));
    }

    public function update(Request $request)
    {
        $pendaki = Auth::guard('pendaki')->user();

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pendakis,nik,' . $pendaki->id,
            'jenis_kelamin' => 'required|in:L,P',
            'umur' => 'required|integer|min:17',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'no_telp_darurat' => 'required|string|max:15',
            'hubungan_darurat' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $pendaki->nama_lengkap = $validated['nama_lengkap'];
        $pendaki->nik = $validated['nik'];
        $pendaki->jenis_kelamin = $validated['jenis_kelamin'];
        $pendaki->umur = $validated['umur'];
        $pendaki->alamat = $validated['alamat'];
        $pendaki->no_telp = $validated['no_telp'];
        $pendaki->no_telp_darurat = $validated['no_telp_darurat'];
        $pendaki->hubungan_darurat = $validated['hubungan_darurat'];

        if ($request->filled('password')) {
            $pendaki->password = Hash::make($validated['password']);
        }

        $pendaki->save();

        return redirect()->route('pendaki.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
}