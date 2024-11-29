@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Active Hiking Status -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Status Pendakian Aktif</h2>
            
            @if($activeBooking)
                <div class="bg-white rounded-lg border p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-gray-600">Tanggal Naik</h3>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($activeBooking->tanggal_naik)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-gray-600">Tanggal Turun</h3>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($activeBooking->tanggal_turun)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-gray-600">Jumlah Anggota</h3>
                            <p class="text-lg font-semibold">{{ $activeBooking->jumlah_anggota }} orang</p>
                        </div>
                        <div>
                            <h3 class="text-gray-600">Status</h3>
                            <p class="text-lg font-semibold">
                                @if(!$activeBooking->hikingStatus)
                                    <span class="text-yellow-600">Menunggu Keberangkatan</span>
                                @elseif($activeBooking->hikingStatus->status === 'hiking')
                                    <span class="text-blue-600">Sedang Mendaki</span>
                                @else
                                    <span class="text-green-600">Selesai</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(!$activeBooking->hikingStatus)
                        <form action="{{ route('pendaki.status.depart') }}" method="POST" class="mt-6">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $activeBooking->id }}">
                            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                                Lapor Keberangkatan
                            </button>
                        </form>
                    @elseif($activeBooking->hikingStatus->status === 'hiking')
                        <div class="mb-6">
                            <h3 class="text-gray-600">Waktu Keberangkatan</h3>
                            <p class="text-lg font-semibold">
                                {{ \Carbon\Carbon::parse($activeBooking->hikingStatus->departure_time)->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <form action="{{ route('pendaki.status.return') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $activeBooking->id }}">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                Lapor Kepulangan
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>Tidak ada pendakian aktif saat ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Hiking History -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Riwayat Pendakian</h2>
            
            @if($completedHikes && $completedHikes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Naik
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Turun
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Keberangkatan
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Kepulangan
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durasi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($completedHikes as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_naik)->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_turun)->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->hikingStatus->departure_time)->format('d F Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->hikingStatus->return_time)->format('d F Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->hikingStatus->departure_time)->diffForHumans(\Carbon\Carbon::parse($booking->hikingStatus->return_time), true) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>Belum ada riwayat pendakian.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    </div>
@endif
@endsection