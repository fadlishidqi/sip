@extends('layouts.app')

@section('title', 'Upload Pembayaran')

@section('content')
    <!-- Main Content -->
    <div class="pt-20 pb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stepper -->
            <div class="mb-8 flex justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-indigo-600">
                        <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">1</span>
                        <span class="ml-2 font-medium">Booking</span>
                    </div>
                    <div class="w-12 h-0.5 bg-indigo-200"></div>
                    <div class="flex items-center text-indigo-600">
                        <span class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center">2</span>
                        <span class="ml-2 font-medium">Pembayaran</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">3</span>
                        <span class="ml-2 font-medium">Selesai</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg shadow-gray-100/40 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Upload Pembayaran</h1>
                    <div class="px-4 py-2 bg-indigo-50 rounded-full">
                        <span class="text-sm font-medium text-indigo-600">ID Booking: #{{ $booking->id }}</span>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl p-6 mb-8 text-white">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-indigo-100 mb-1">Tanggal Naik</p>
                            <p class="text-lg font-semibold">{{ date('d F Y', strtotime($booking->tanggal_naik)) }}</p>
                        </div>
                        <div>
                            <p class="text-indigo-100 mb-1">Jumlah Anggota</p>
                            <p class="text-lg font-semibold">{{ $booking->jumlah_anggota }} orang</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-indigo-100 mb-1">Total Pembayaran</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($booking->jumlah_anggota * 25000, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Information -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="ph-bank text-xl text-indigo-600"></i>
                        <h2 class="text-lg font-semibold text-gray-900">Rekening Pembayaran</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                            <img src="../images/bca-logo.png" alt="BCA" class="h-8 mb-3">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xl font-mono font-medium text-gray-900">1234567890</p>
                                <button onclick="copyToClipboard('1234567890')" class="text-indigo-600 hover:text-indigo-700">
                                    <i class="ph-copy text-lg"></i>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600">a.n. Pengelola Gunung Ungaran</p>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                            <img src="../images/mandiri-logo.png" alt="Mandiri" class="h-8 mb-3">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xl font-mono font-medium text-gray-900">0987654321</p>
                                <button onclick="copyToClipboard('0987654321')" class="text-indigo-600 hover:text-indigo-700">
                                    <i class="ph-copy text-lg"></i>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600">a.n. Pengelola Gunung Ungaran</p>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <form method="POST" action="{{ route('pendaki.payment.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bank Pengirim*</label>
                            <select name="bank_pengirim" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Bank</option>
                                <option value="BCA">BCA</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                            </select>
                            @error('bank_pengirim')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengirim*</label>
                            <input type="text" 
                                name="nama_pengirim" 
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('nama_pengirim')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer*</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-indigo-100 border-dashed rounded-xl bg-indigo-50/50 hover:bg-indigo-50 transition-colors">
                            <div class="space-y-2 text-center">
                                <div id="preview-container" class="hidden mb-8">
                                    <img id="preview-image" src="#" alt="Preview" class="mx-auto max-h-40 rounded-lg">
                                </div>
                                <i class="ph-upload-simple text-4xl text-indigo-500"></i>
                                <div class="text-sm text-gray-600">
                                    <label for="file-upload" class="relative mt-8 px-6 py-3 cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload file</span>
                                        <input id="file-upload" name="bukti_pembayaran" type="file" class="sr-only" accept="image/*" required onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1 mt-6">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG (max. 2MB)</p>
                            </div>
                        </div>
                        @error('bukti_pembayaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <script>
                    function previewImage(input) {
                        const preview = document.getElementById('preview-image');
                        const container = document.getElementById('preview-container');
                        
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                container.classList.remove('hidden');
                            }
                            
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    </script>

                    <button type="submit" 
                        class="w-full mt-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3.5 rounded-xl font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Upload dan Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show toast notification
                alert('Nomor rekening berhasil disalin');
            });
        }
    </script>
@endpush