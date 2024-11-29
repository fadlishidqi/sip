<?php

namespace App\Http\Controllers;

use App\Models\HikingStatus;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatusController extends Controller
{
    public function index()
    {
        $pendaki = Auth::guard('pendaki')->user();
        
        // Get active booking
        $activeBooking = $pendaki->bookings()
            ->with('hikingStatus')
            ->where('status', 'confirmed')
            ->whereHas('hikingStatus', function($query) {
                $query->whereNull('return_time');
            })
            ->orWhere(function($query) {
                $query->where('status', 'confirmed')
                    ->doesntHave('hikingStatus');
            })
            ->latest()
            ->first();

        // Get completed hikes
        $completedHikes = $pendaki->bookings()
            ->with(['hikingStatus'])
            ->whereHas('hikingStatus', function($query) {
                $query->whereNotNull('return_time');
            })
            ->orderBy('tanggal_naik', 'desc')
            ->get();

        return view('pendaki.status.index', compact('activeBooking', 'completedHikes'));
    }

    public function depart(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        
        if ($booking->pendaki_id !== Auth::guard('pendaki')->id()) {
            abort(403);
        }

        // Validate hiking date
        if (Carbon::now()->lt($booking->tanggal_naik)) {
            return back()->with('error', 'Belum waktunya untuk mendaki! Tunggu sampai tanggal yang telah dijadwalkan.');
        }

        HikingStatus::create([
            'booking_id' => $booking->id,
            'departure_time' => now(),
            'status' => 'hiking'
        ]);

        return redirect()->route('pendaki.status')->with('success', 'Keberangkatan berhasil dicatat');
    }

    public function return(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        
        if ($booking->pendaki_id !== Auth::guard('pendaki')->id()) {
            abort(403);
        }
    
        $status = HikingStatus::where('booking_id', $booking->id)->firstOrFail();
        
        if ($status->departure_time->diffInSeconds(now()) < 10) {
            return back()->with('error', 'Waktu pendakian terlalu singkat. Pastikan Anda telah benar-benar selesai mendaki.');
        }
    
        $status->update([
            'return_time' => now(),
            'status' => 'completed'
        ]);
    
        return redirect()->route('pendaki.status')->with('success', 'Kepulangan berhasil dicatat');
    }
}