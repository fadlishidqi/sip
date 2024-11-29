<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaki</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-['Inter'] min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-indigo-600">SIPendaki</span>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="p-1 text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if(count(Auth::guard('pendaki')->user()->unreadNotifications) > 0)
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                            @endif
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('pendaki.profile') }}" class="flex items-center space-x-2 hover:bg-gray-50 p-2 rounded-lg">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">{{ substr(Auth::guard('pendaki')->user()->nama_lengkap, 0, 1) }}</span>
                            </div>
                            <div class="text-sm">
                                <p class="font-medium text-gray-700">{{ Auth::guard('pendaki')->user()->nama_lengkap }}</p>
                                <p class="text-gray-500 text-xs">Pendaki</p>
                            </div>
                        </a>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('pendaki.logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ Auth::guard('pendaki')->user()->nama_lengkap }}</h1>
                <p class="text-gray-600">Kelola pendakian Anda dengan mudah</p>
            </div>

            <!-- Active Booking Alert (if exists) -->
            @if($activeBooking = Auth::guard('pendaki')->user()->bookings()->where('status', 'confirmed')->first())
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Pendakian Aktif</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Anda memiliki jadwal pendakian pada tanggal {{ date('d F Y', strtotime($activeBooking->tanggal_naik)) }}</p>
                            </div>
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5 flex">
                                    <a href="{{ route('pendaki.booking.show', $activeBooking->id) }}" 
                                    class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Menu Grid -->
            <div class="grid grid-cols-4 gap-6">
                <!-- Card Jadwal Pendakian (Besar) -->
                <div class="col-span-2 relative bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all">
                    <a href="{{ route('pendaki.booking') }}" class="block">
                        <img src="../images/gunung1.jpg" alt="Mountain" class="w-full h-[400px] object-cover rounded-xl mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-green-50 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Jadwal Pendakian</h3>
                                <p class="text-gray-600 mt-1">Atur jadwal dan rencana pendakian Anda</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card-card Kanan -->
                <div class="space-y-6 col-span-2">
                    <!-- Info Kepadatan -->
                    <div class="w-full bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all">
                        <a href="{{ route('pendaki.crowding') }}" class="block">
                            <div class="p-2 bg-yellow-100 rounded-lg w-12 h-12 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Info Kepadatan</h3>
                            <p class="text-gray-600">Pantau kepadatan jalur pendakian secara real-time</p>
                        </a>
                    </div>

                    <!-- Riwayat Pembayaran -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all">
                        <a href="{{ route('pendaki.payment.history') }}" class="block">
                            <div class="p-2 bg-purple-100 rounded-lg w-12 h-12 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Riwayat Pembayaran</h3>
                            <p class="text-gray-600">Lihat history pembayaran dan status transaksi Anda</p>
                        </a>
                    </div>

                    <!-- Status Pendakian -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:border-indigo-500 hover:shadow-md transition-all">
                        <a href="{{ route('pendaki.status') }}" class="block">
                            <div class="p-2 bg-red-100 rounded-lg w-12 h-12 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Status Pendakian</h3>
                            <p class="text-gray-600">Pantau dan perbarui status pendakian Anda</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Latest Notifications -->
            @if(count(Auth::guard('pendaki')->user()->notifications) > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Notifikasi Terbaru</h2>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y divide-gray-200">
                        @foreach(Auth::guard('pendaki')->user()->notifications()->limit(5)->get() as $notification)
                            <div class="p-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        @if($notification->type === 'App\Notifications\PaymentStatusUpdated')
                                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-900">
                                            {{ $notification->data['message'] ?? 'Status pembayaran Anda telah diperbarui' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Email</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400">
                        &copy; {{ date('Y') }} SIPendaki. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Notification Scripts -->
    <script>
        // Mark notifications as read when clicked
        document.querySelectorAll('[data-notification]').forEach(notification => {
            notification.addEventListener('click', async () => {
                const id = notification.dataset.notification;
                try {
                    await fetch(`/notifications/${id}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });
                    notification.classList.remove('bg-blue-50');
                    notification.classList.add('bg-white');
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            });
        });
    </script>
</body>
</html>