<!DOCTYPE html>
<html>
<head>
    <title>Register Pendaki</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Register Pendaki</h2>
            
            <form method="POST" action="{{ route('pendaki.register') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror"
                        id="username" type="text" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_lengkap">
                        Nama Lengkap*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_lengkap') border-red-500 @enderror"
                        id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nik">
                        NIK*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nik') border-red-500 @enderror"
                        id="nik" type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" minlength="16">
                    @error('nik')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Jenis Kelamin*
                    </label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                            <span class="ml-2">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="umur">
                        Umur*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('umur') border-red-500 @enderror"
                        id="umur" type="number" name="umur" value="{{ old('umur') }}" required min="17">
                    @error('umur')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                        Alamat*
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat') border-red-500 @enderror"
                        id="alamat" name="alamat" required rows="3">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no_telp">
                        Nomor Telepon*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('no_telp') border-red-500 @enderror"
                        id="no_telp" type="tel" name="no_telp" value="{{ old('no_telp') }}" required>
                    @error('no_telp')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no_telp_darurat">
                        Nomor Telepon Darurat*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('no_telp_darurat') border-red-500 @enderror"
                        id="no_telp_darurat" type="tel" name="no_telp_darurat" value="{{ old('no_telp_darurat') }}" required>
                    @error('no_telp_darurat')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="hubungan_darurat">
                        Hubungan dengan Kontak Darurat*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('hubungan_darurat') border-red-500 @enderror"
                        id="hubungan_darurat" type="text" name="hubungan_darurat" value="{{ old('hubungan_darurat') }}" required>
                    @error('hubungan_darurat')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                        id="password" type="password" name="password" required>
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                        Konfirmasi Password*
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Register
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                        href="{{ route('pendaki.login') }}">
                        Sudah punya akun? Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>