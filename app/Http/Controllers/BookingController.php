<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        return view('pendaki.booking.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_naik' => 'required|date|after_or_equal:today',
            'tanggal_turun' => 'required|date|after:tanggal_naik',
            'jumlah_anggota' => 'required|integer|min:1|max:10',
        ]);

        $booking = new Booking();
        $booking->pendaki_id = Auth::guard('pendaki')->id();
        $booking->tanggal_naik = $validated['tanggal_naik'];
        $booking->tanggal_turun = $validated['tanggal_turun'];
        $booking->jumlah_anggota = $validated['jumlah_anggota'];
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('pendaki.payment', ['booking' => $booking->id])
            ->with('success', 'Jadwal pendakian berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking)
    {
        if ($booking->pendaki_id !== Auth::guard('pendaki')->id()) {
            abort(403);
        }

        return view('pendaki.booking.show', compact('booking'));
    }
}