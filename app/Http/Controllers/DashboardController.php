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
        $bulanini = date("m") * 1;
        $tahunini = date("Y");

        // NIK pengguna yang sedang login
        $nik = Auth::guard('karyawan')->user()->nik;

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

        $rekappresensi= DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir')
        ->where('nik', $nik)
        ->where('nik', $nik)
        ->whereMonth('tgl_presensi', $bulanini)
        ->whereYear('tgl_presensi', $tahunini)
        ->first();


        $leaderboard = DB::table('presensi')
        ->join('karyawan','presensi.nik','=', 'karyawan.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();
        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        // Kirim data ke view
        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard'));
    }
}

