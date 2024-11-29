<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kepadatan | SIPendaki</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-['Plus_Jakarta_Sans']">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('pendaki.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                        < Kembali ke Dashboard
                    </a>
                </div>
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-500">{{ Auth::guard('pendaki')->user()->nama_lengkap }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kepadatan Jalur Pendakian</h1>

        <!-- Status Hari Ini -->
        @if($today)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Hari Ini</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500 mb-1">Tanggal</p>
                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($today['tanggal'])->format('d F Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500 mb-1">Jumlah Pendaki</p>
                    <p class="text-lg font-semibold">{{ $today['jumlah_pendaki'] }} orang</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($today['status']['level'] === 'low') bg-green-100 text-green-800
                            @elseif($today['status']['level'] === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $today['status']['text'] }}
                        </span>
                        <span class="text-sm text-gray-600">- {{ $today['status']['rekomendasi'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Peak Days -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Hari Terpadat (30 Hari Kedepan)</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($peakDays as $day)
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($day['tanggal'])->format('d F Y') }}</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($day['status']['level'] === 'low') bg-green-100 text-green-800
                            @elseif($day['status']['level'] === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $day['status']['text'] }}
                        </span>
                    </div>
                    <p class="text-lg font-semibold">{{ $day['jumlah_pendaki'] }} pendaki</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Grafik Kepadatan 30 Hari Kedepan</h2>
            <div class="h-80">
                <canvas id="crowdingChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('crowdingChart').getContext('2d');
        const data = @json($crowdingData);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => new Date(item.tanggal).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})),
                datasets: [{
                    label: 'Jumlah Pendaki',
                    data: data.map(item => item.jumlah_pendaki),
                    backgroundColor: data.map(item => {
                        switch(item.status.level) {
                            case 'low': return 'rgba(34, 197, 94, 0.5)';
                            case 'medium': return 'rgba(234, 179, 8, 0.5)';
                            default: return 'rgba(239, 68, 68, 0.5)';
                        }
                    }),
                    borderColor: data.map(item => {
                        switch(item.status.level) {
                            case 'low': return 'rgb(34, 197, 94)';
                            case 'medium': return 'rgb(234, 179, 8)';
                            default: return 'rgb(239, 68, 68)';
                        }
                    }),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pendaki'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>