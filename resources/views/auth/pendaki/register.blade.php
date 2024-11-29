<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register | SIPendaki</title>
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter']">
   <div class="min-h-screen flex">
       <!-- Left side -->
       <div class="hidden lg:block lg:w-1/2 relative">
           <img src="../images/gunung3.jpg" alt="Mountain" class="w-full h-screen object-cover">
           <div class="absolute inset-0 bg-black bg-opacity-30">
               <div class="p-12 absolute bottom-0 text-white">
                   <h1 class="text-4xl font-bold mb-2">SIPendaki</h1>
                   <p class="text-lg">Your Mountain Adventure Starts Here</p>
               </div>
           </div>
       </div>

       <!-- Right side -->
       <div class="w-full lg:w-1/2 overflow-y-auto h-screen">
           <div class="max-w-md mx-auto px-6 py-12">
               <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
               <p class="text-gray-600 mb-8">Register your climbing account</p>

               <form method="POST" action="{{ route('pendaki.register') }}" class="space-y-4">
                   @csrf
                   <!-- Username -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-1">Username*</label>
                       <input type="text" name="username" value="{{ old('username') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                       @error('username')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                   </div>

                   <!-- Nama Lengkap -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap*</label>
                       <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                       @error('nama_lengkap')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                   </div>

                   <!-- NIK -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-1">NIK*</label>
                       <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" minlength="16"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                       @error('nik')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                   </div>

                   <!-- Jenis Kelamin -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin*</label>
                       <div class="flex gap-6">
                           <label class="flex items-center">
                               <input type="radio" name="jenis_kelamin" value="L" required
                                   class="form-radio text-indigo-600" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                               <span class="ml-2">Laki-laki</span>
                           </label>
                           <label class="flex items-center">
                               <input type="radio" name="jenis_kelamin" value="P" 
                                   class="form-radio text-indigo-600" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                               <span class="ml-2">Perempuan</span>
                           </label>
                       </div>
                   </div>

                   <!-- Umur -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-1">Umur*</label>
                       <input type="number" name="umur" value="{{ old('umur') }}" required min="17"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                       @error('umur')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                   </div>

                   <!-- Alamat -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-1">Alamat*</label>
                       <textarea name="alamat" required rows="3" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('alamat') }}</textarea>
                       @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                   </div>

                   <!-- Contact Information -->
                   <div class="space-y-4">
                       <div>
                           <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon*</label>
                           <input type="tel" name="no_telp" value="{{ old('no_telp') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                           @error('no_telp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                       </div>

                       <div>
                           <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Darurat*</label>
                           <input type="tel" name="no_telp_darurat" value="{{ old('no_telp_darurat') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                           @error('no_telp_darurat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                       </div>

                       <div>
                           <label class="block text-sm font-medium text-gray-700 mb-1">Hubungan dengan Kontak Darurat*</label>
                           <input type="text" name="hubungan_darurat" value="{{ old('hubungan_darurat') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                           @error('hubungan_darurat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                       </div>
                   </div>

                   <!-- Password -->
                   <div class="space-y-4">
                       <div>
                           <label class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                           <input type="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                           @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                       </div>

                       <div>
                           <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password*</label>
                           <input type="password" name="password_confirmation" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                       </div>
                   </div>

                   <!-- Submit -->
                   <div class="flex items-center justify-between pt-6">
                       <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-indigo-700 
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                           Register
                       </button>
                       <a href="{{ route('pendaki.login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                           Already have an account?
                       </a>
                   </div>
               </form>
           </div>
       </div>
   </div>
</body>
</html>