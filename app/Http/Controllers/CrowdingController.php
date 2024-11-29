<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CrowdingController extends Controller
{
    public function index()
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(30);

        $crowdingData = Booking::select(
                DB::raw('DATE(tanggal_naik) as tanggal'),
                DB::raw('SUM(jumlah_anggota) as jumlah_pendaki')
            )
            ->where('status', 'confirmed')
            ->whereBetween('tanggal_naik', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'jumlah_pendaki' => (int) $item->jumlah_pendaki,
                    'status' => $this->getStatusKepadatan($item->jumlah_pendaki)
                ];
            });

        // Data hari ini
        $today = $crowdingData->where('tanggal', now()->format('Y-m-d'))->first();
        
        // Data 3 hari terpadat
        $peakDays = $crowdingData->sortByDesc('jumlah_pendaki')->take(3);

        return view('pendaki.crowding.index', compact('crowdingData', 'today', 'peakDays'));
    }

    private function getStatusKepadatan($jumlahPendaki)
    {
        if ($jumlahPendaki <= 50) {
            return [
                'level' => 'low',
                'text' => 'Sepi',
                'color' => 'green',
                'rekomendasi' => 'Waktu yang ideal untuk pendakian yang tenang'
            ];
        } elseif ($jumlahPendaki <= 100) {
            return [
                'level' => 'medium',
                'text' => 'Normal',
                'color' => 'yellow',
                'rekomendasi' => 'Disarankan berangkat lebih pagi'
            ];
        } else {
            return [
                'level' => 'high',
                'text' => 'Padat',
                'color' => 'red',
                'rekomendasi' => 'Pertimbangkan untuk memilih tanggal lain'
            ];
        }
    }
}