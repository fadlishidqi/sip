@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Detail Booking</h1>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">ID Booking</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $booking->id }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1 text-sm">
                            @if($booking->status == 'pending')
                                <span class="px-2 py-1 text-yellow-800 bg-yellow-100 rounded-full">Menunggu Pembayaran</span>
                            @elseif($booking->status == 'confirmed')
                                <span class="px-2 py-1 text-green-800 bg-green-100 rounded-full">Terkonfirmasi</span>
                            @else
                                <span class="px-2 py-1 text-red-800 bg-red-100 rounded-full">Dibatalkan</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Naik</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ date('d F Y', strtotime($booking->tanggal_naik)) }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Turun</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ date('d F Y', strtotime($booking->tanggal_turun)) }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Jumlah Anggota</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $booking->jumlah_anggota }} orang</p>
                    </div>
                </div>

                @if($booking->status == 'pending')
                    <div class="mt-6">
                        <a href="{{ route('pendaki.payment', ['booking' => $booking->id]) }}" 
                            class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-md hover:bg-indigo-700">
                            Lakukan Pembayaran
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection