@extends('layouts.app')

@section('title', 'Jadwal Pendakian')

@section('content')

    <!-- Main Content -->
    <div class="pt-20 pb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stepper -->
            <div class="mb-8 flex justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-indigo-600">
                        <span class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center">1</span>
                        <span class="ml-2 font-medium">Booking</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">2</span>
                        <span class="ml-2 font-medium">Pembayaran</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">3</span>
                        <span class="ml-2 font-medium">Selesai</span>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="ph-warning-circle text-xl text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg shadow-gray-100/40 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Jadwal Pendakian</h1>
                    <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-full text-sm font-medium">
                        {{ date('F Y') }}
                    </span>
                </div>

                <form method="POST" action="{{ route('pendaki.booking.store') }}" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal Naik -->
                        <div class="bg-gray-50 p-6 rounded-xl space-y-2">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="ph-calendar-plus text-xl text-indigo-600"></i>
                                <label class="text-sm font-medium text-gray-700">Tanggal Naik*</label>
                            </div>
                            <input type="date" 
                                name="tanggal_naik" 
                                value="{{ old('tanggal_naik') }}"
                                required
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('tanggal_naik')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Turun -->
                        <div class="bg-gray-50 p-6 rounded-xl space-y-2">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="ph-calendar-minus text-xl text-indigo-600"></i>
                                <label class="text-sm font-medium text-gray-700">Tanggal Turun*</label>
                            </div>
                            <input type="date" 
                                name="tanggal_turun" 
                                value="{{ old('tanggal_turun') }}"
                                required
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('tanggal_turun')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Anggota -->
                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl space-y-2">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="ph-users text-xl text-indigo-600"></i>
                                <label class="text-sm font-medium text-gray-700">Jumlah Anggota*</label>
                            </div>
                            <input type="number" 
                                name="jumlah_anggota" 
                                value="{{ old('jumlah_anggota', 1) }}"
                                required
                                min="1"
                                max="10"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="flex items-center gap-2 mt-2">
                                <i class="ph-info text-indigo-500"></i>
                                <p class="text-sm text-gray-500">Maksimal 10 orang per kelompok</p>
                            </div>
                            @error('jumlah_anggota')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Informasi Penting -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="ph-info text-xl text-blue-600"></i>
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Penting</h2>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2">
                                <i class="ph-check-circle text-blue-500 mt-1"></i>
                                <span class="text-gray-600">Pastikan tanggal pendakian sesuai dengan rencana Anda</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-check-circle text-blue-500 mt-1"></i>
                                <span class="text-gray-600">Maksimal durasi pendakian adalah 3 hari</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="ph-check-circle text-blue-500 mt-1"></i>
                                <span class="text-gray-600">Pembayaran harus dilakukan dalam waktu 24 jam</span>
                            </li>
                        </ul>
                    </div>

                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3.5 rounded-xl font-medium hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all flex items-center justify-center gap-2">
                        <i class="ph-calendar-check text-xl"></i>
                        Buat Jadwal Pendakian
                    </button>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 text-center text-sm text-gray-500">
                Butuh bantuan? <a href="#" class="text-indigo-600 hover:text-indigo-700">Hubungi kami</a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add any necessary JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Validation for date range (max 3 days)
            const tanggalNaik = document.querySelector('input[name="tanggal_naik"]');
            const tanggalTurun = document.querySelector('input[name="tanggal_turun"]');

            function validateDates() {
                if (tanggalNaik.value && tanggalTurun.value) {
                    const naik = new Date(tanggalNaik.value);
                    const turun = new Date(tanggalTurun.value);
                    const diff = (turun - naik) / (1000 * 60 * 60 * 24);
                    
                    if (diff > 3) {
                        alert('Maksimal durasi pendakian adalah 3 hari!');
                        tanggalTurun.value = '';
                    }
                }
            }

            tanggalNaik.addEventListener('change', validateDates);
            tanggalTurun.addEventListener('change', validateDates);
        });
    </script>
    @endpush
@endsection