@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg animate-fade-in-down">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Edit Profil</h2>

            <form method="POST" action="{{ route('pendaki.profile') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div class="bg-gray-50 rounded-xl p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>

                    <!-- Username (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <p class="text-gray-600 bg-gray-100 px-3 py-2 rounded-lg">{{ $pendaki->username }}</p>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nama_lengkap">Nama Lengkap*</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_lengkap') @enderror"
                            id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pendaki->nama_lengkap) }}" required>
                        @error('nama_lengkap')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nik">NIK*</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nik') @enderror"
                            id="nik" type="text" name="nik" value="{{ old('nik', $pendaki->nik) }}" required maxlength="16" minlength="16">
                        @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin*</label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio text-indigo-600" name="jenis_kelamin" value="L" 
                                    {{ old('jenis_kelamin', $pendaki->jenis_kelamin) == 'L' ? 'checked' : '' }} required>
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio text-indigo-600" name="jenis_kelamin" value="P"
                                    {{ old('jenis_kelamin', $pendaki->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Umur -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="umur">Umur*</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('umur') @enderror"
                            id="umur" type="number" name="umur" value="{{ old('umur', $pendaki->umur) }}" required min="17">
                        @error('umur')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="alamat">Alamat*</label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('alamat') @enderror"
                            id="alamat" name="alamat" required rows="3">{{ old('alamat', $pendaki->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="bg-gray-50 rounded-xl p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>

                    <!-- No Telp -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_telp">Nomor Telepon*</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('no_telp') @enderror"
                            id="no_telp" type="tel" name="no_telp" value="{{ old('no_telp', $pendaki->no_telp) }}" required>
                        @error('no_telp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Telp Darurat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="no_telp_darurat">Nomor Telepon Darurat*</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('no_telp_darurat') @enderror"
                            id="no_telp_darurat" type="tel" name="no_telp_darurat" value="{{ old('no_telp_darurat', $pendaki->no_telp_darurat) }}" required>
                        @error('no_telp_darurat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hubungan Darurat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="hubungan_darurat">Hubungan dengan Kontak Darurat*</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('hubungan_darurat') @enderror"
                            id="hubungan_darurat" type="text" name="hubungan_darurat" value="{{ old('hubungan_darurat', $pendaki->hubungan_darurat) }}" required>
                        @error('hubungan_darurat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="bg-gray-50 rounded-xl p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900">Ubah Password</h3>
                    <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password</p>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password Baru</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') @enderror"
                            id="password" type="password" name="password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Konfirmasi Password Baru</label>
                        <input class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            id="password_confirmation" type="password" name="password_confirmation">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection