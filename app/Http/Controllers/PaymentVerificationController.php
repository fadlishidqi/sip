<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Notifications\PaymentStatusUpdated;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.pendaki'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('booking.pendaki');
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected',
            'catatan' => 'required_if:status,rejected|nullable|string'
        ]);

        $payment->status = $validated['status'];
        $payment->catatan = $validated['catatan'];
        $payment->save();

        // Update booking status jika pembayaran dikonfirmasi
        if ($validated['status'] === 'confirmed') {
            $payment->booking->update(['status' => 'confirmed']);
        }

        // Kirim notifikasi ke pendaki
        $payment->booking->pendaki->notify(new PaymentStatusUpdated($payment));

        return redirect()->route('admin.payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui');
    }
}