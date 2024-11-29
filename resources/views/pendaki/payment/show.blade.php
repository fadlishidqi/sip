<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran | SIPendaki</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/phosphor-icons"></script>
</head>
<body class="bg-[#F8FAFC] font-['Plus_Jakarta_Sans']">
    <!-- Fixed Navbar -->
    <nav class="bg-white/80 backdrop-blur-lg border-b border-gray-200 fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('pendaki.dashboard') }}" class="group flex items-center text-gray-500 hover:text-indigo-600 transition-all">
                        <i class="ph-arrow-left text-lg mr-2 transition-transform group-hover:-translate-x-1"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white">
                        <span class="font-medium">{{ substr(Auth::guard('pendaki')->user()->nama_lengkap, 0, 1) }}</span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ Auth::guard('pendaki')->user()->nama_lengkap }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 pb-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl animate-fade-in-down">
                    <div class="flex">
                        <i class="ph-check-circle text-xl text-green-500"></i>
                        <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg shadow-gray-100/40 p-8">
                <!-- Header with Status -->
                <div class="border-b border-gray-100 pb-8 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Detail Pembayaran</h1>
                        <div class="px-4 py-2 bg-indigo-50 rounded-full">
                            <span class="text-sm font-medium text-indigo-600">ID Booking: #{{ $payment->booking->id }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Status Badge -->
                        <div class="col-span-2">
                            @if($payment->status == 'pending')
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                        <i class="ph-clock text-xl text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                                        <p class="font-semibold text-yellow-600">Menunggu Verifikasi</p>
                                    </div>
                                </div>
                            @elseif($payment->status == 'confirmed')
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                        <i class="ph-check-circle text-xl text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                                        <p class="font-semibold text-green-600">Pembayaran Dikonfirmasi</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                                        <i class="ph-x-circle text-xl text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                                        <p class="font-semibold text-red-600">Pembayaran Ditolak</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Upload Time -->
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Tanggal Upload</p>
                            <p class="font-medium text-gray-900">{{ $payment->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    @if($payment->catatan)
                        <div class="mt-6 bg-red-50 rounded-xl p-4">
                            <div class="flex gap-3">
                                <i class="ph-info text-xl text-red-500 mt-0.5"></i>
                                <div>
                                    <h3 class="font-medium text-red-800 mb-1">Catatan Admin:</h3>
                                    <p class="text-sm text-red-700">{{ $payment->catatan }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Payment and Booking Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Payment Info -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="ph-bank text-xl text-indigo-600"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Info Pembayaran</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Bank Pengirim</p>
                                <p class="font-medium text-gray-900">{{ $payment->bank_pengirim }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nama Pengirim</p>
                                <p class="font-medium text-gray-900">{{ $payment->nama_pengirim }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="ph-calendar text-xl text-indigo-600"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Detail Booking</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Pendakian</p>
                                <p class="font-medium text-gray-900">{{ date('d F Y', strtotime($payment->booking->tanggal_naik)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Anggota</p>
                                <p class="font-medium text-gray-900">{{ $payment->booking->jumlah_anggota }} Orang</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Proof -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="ph-image text-xl text-indigo-600"></i>
                        <h3 class="text-lg font-semibold text-gray-900">Bukti Transfer</h3>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <img src="{{ Storage::url($payment->bukti_pembayaran) }}" 
                            alt="Bukti Transfer" 
                            class="w-full max-w-2xl mx-auto rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add image preview enlargement functionality if needed
        document.querySelector('img').addEventListener('click', function() {
            // Add image preview logic here
        });
    </script>
</body>
</html>