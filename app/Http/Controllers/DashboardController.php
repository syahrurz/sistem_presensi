<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tanggal, bulan, dan tahun saat ini
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; // Konversi bulan ke integer
        $tahunini = date("Y");

        // Ambil user yang sedang login
        $user = Auth::user(); // Menggunakan Auth default Laravel
        $nik = $user->nik; // Ambil NIK dari user yang login

        // Ambil data presensi hari ini
        $presensihariini = DB::table('presensi')
            ->where('nik', $nik)
            ->where('tgl_presensi', $hariini)
            ->first();

        // Ambil histori presensi bulan ini
        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereMonth('tgl_presensi', $bulanini)
            ->whereYear('tgl_presensi', $tahunini)
            ->orderBy('tgl_presensi', 'asc') // Data diurutkan dari yang terlama ke terbaru
            ->get();

        // Rekap presensi bulan ini
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir')
            ->where('nik', $nik)
            ->whereMonth('tgl_presensi', $bulanini)
            ->whereYear('tgl_presensi', $tahunini)
            ->first();

        // Leaderboard berdasarkan jam masuk (jam_in) pada hari ini
        $leaderboard = DB::table('presensi')
            ->join('users', 'presensi.nik', '=', 'users.nik') // Gabung dengan tabel `users`
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in') // Urutkan berdasarkan waktu masuk
            ->get();

        // Nama bulan
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Kirim data ke view
        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard'));
    }
}
