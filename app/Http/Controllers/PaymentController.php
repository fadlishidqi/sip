<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PaymentStatusUpdated;

class PaymentController extends Controller
{
    public function index()
    {
        $pendaki = Auth::guard('pendaki')->user();
        $payments = Payment::whereHas('booking', function($query) use($pendaki) {
            $query->where('pendaki_id', $pendaki->id);
        })->orderBy('created_at', 'desc')->get();

        return view('pendaki.payment.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $booking = Booking::findOrFail($request->booking);
        
        // Cek apakah booking milik pendaki yang sedang login
        if ($booking->pendaki_id !== Auth::guard('pendaki')->id()) {
            abort(403);
        }

        // Cek apakah sudah ada pembayaran untuk booking ini
        if ($booking->payment) {
            return redirect()->route('pendaki.payment.show', $booking->payment->id);
        }

        // Hitung total pembayaran
        $totalPembayaran = $booking->jumlah_anggota * 25000; // Rp 25.000 per orang

        return view('pendaki.payment.create', compact('booking', 'totalPembayaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'bukti_pembayaran' => 'required|image|max:2048', 
            'bank_pengirim' => 'required|string|max:50',
            'nama_pengirim' => 'required|string|max:255',
        ]);

        // Cek apakah booking milik pendaki yang sedang login
        $booking = Booking::with('pendaki')->findOrFail($validated['booking_id']);
        if ($booking->pendaki_id !== Auth::guard('pendaki')->id()) {
            abort(403);
        }

        try {
            // Upload bukti pembayaran
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('bukti-pembayaran', $filename, 'public');
            }

            // Buat payment record
            $payment = Payment::create([
                'booking_id' => $validated['booking_id'],
                'bukti_pembayaran' => $path,
                'bank_pengirim' => $validated['bank_pengirim'],
                'nama_pengirim' => $validated['nama_pengirim'],
                'status' => 'pending'
            ]);

            return redirect()->route('pendaki.payment.show', $payment->id)
                ->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi.');

        } catch (\Exception $e) {
            \Log::error('Upload Error: ' . $e->getMessage());
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            return back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }

    public function show(Payment $payment)
    {
        // Cek apakah payment milik pendaki yang sedang login
        if ($payment->booking->pendaki_id !== Auth::guard('pendaki')->id()) {
            abort(403);
        }

        // Hitung total pembayaran
        $totalPembayaran = $payment->booking->jumlah_anggota * 25000;

        return view('pendaki.payment.show', compact('payment', 'totalPembayaran'));
    }

    // Method untuk mengupdate status pembayaran (untuk admin)
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected',
            'catatan' => 'required_if:status,rejected'
        ]);

        $payment->status = $validated['status'];
        $payment->catatan = $validated['catatan'];
        $payment->save();

        // Update status booking jika pembayaran dikonfirmasi
        if ($validated['status'] === 'confirmed') {
            $payment->booking->status = 'confirmed';
            $payment->booking->save();
        }

        // Kirim notifikasi ke pendaki
        $payment->booking->pendaki->notify(new PaymentStatusUpdated($payment));

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    // Method untuk mendapatkan bukti pembayaran
    public function getBuktiPembayaran($filename)
    {
        $path = 'bukti-pembayaran/' . $filename;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path);
    }

    // Method untuk menghapus pembayaran (opsional, untuk admin)
    public function destroy(Payment $payment)
    {
        // Hapus file bukti pembayaran
        if (Storage::disk('public')->exists($payment->bukti_pembayaran)) {
            Storage::disk('public')->delete($payment->bukti_pembayaran);
        }

        // Hapus record payment
        $payment->delete();

        return back()->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function history()
    {
        $pendaki = Auth::guard('pendaki')->user();
        $payments = Payment::with('booking')
            ->whereHas('booking', function($query) use($pendaki) {
                $query->where('pendaki_id', $pendaki->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pendaki.payment.history', compact('payments'));
    }
}