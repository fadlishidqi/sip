<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentStatusUpdated extends Notification
{
    protected $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $status = $this->payment->status === 'confirmed' ? 'dikonfirmasi' : 'ditolak';
        
        return (new MailMessage)
            ->subject('Status Pembayaran ' . ucfirst($status))
            ->line('Status pembayaran Anda telah diperbarui.')
            ->line('ID Booking: ' . $this->payment->booking->id)
            ->line('Status: ' . ucfirst($status))
            ->when($this->payment->catatan, function ($message) {
                return $message->line('Catatan: ' . $this->payment->catatan);
            })
            ->action('Lihat Detail', route('pendaki.payment.show', $this->payment->id));
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'booking_id' => $this->payment->booking_id,
            'status' => $this->payment->status,
            'catatan' => $this->payment->catatan
        ];
    }
}