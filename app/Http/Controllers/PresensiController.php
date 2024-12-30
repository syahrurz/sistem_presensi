<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiController extends Controller
{
    // Halaman untuk presensi (masuk)
    public function create()
    {
        // Ambil tanggal hari ini
        $hariini = date("Y-m-d");
        // Ambil NIK karyawan yang sedang login
        $nik = Auth::user()->nik;

        // Cek apakah sudah ada presensi untuk hari ini
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('nik', $nik)
            ->count();

        return view('presensi.create', compact('cek'));
    }

    // Proses untuk menyimpan presensi (masuk atau pulang)
    public function store(Request $request)
    {
        try {
            $nik = Auth::user()->nik;
            $tgl_presensi = date("Y-m-d");
            $jam = date("H:i:s");
            $lokasi = $request->lokasi;

            $presensiHariIni = DB::table('presensi')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('nik', $nik)
                ->first();

            if ($presensiHariIni) {
                if ($presensiHariIni->jam_out) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah melakukan presensi pulang hari ini.'
                    ]);
                }

                $update = DB::table('presensi')
                    ->where('tgl_presensi', $tgl_presensi)
                    ->where('nik', $nik)
                    ->update([
                        'jam_out' => $jam,
                        'lokasi_out' => $lokasi,
                        'updated_at' => now()
                    ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Terima kasih, hati-hati di jalan'
                ]);
            }

            $simpan = DB::table('presensi')->insert([
                'nik' => $nik,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'lokasi_in' => $lokasi,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Terima kasih, selamat bekerja'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Halaman izin
    public function izin()
    {
        $nik = Auth::user()->nik;
        $dataizin = DB::table('pengajuan_izin')
            ->where('nik', $nik)
            ->orderBy('tgl_izin', 'desc')
            ->get();

        return view('presensi.izin', compact('dataizin'));
    }

    // Halaman buat izin
    public function buatizin()
    {
        return view('presensi.buatizin');
    }

    // Proses simpan izin
    public function storeizin(Request $request)
    {
        $nik = Auth::user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    // Halaman histori presensi
    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    // Mengambil histori presensi karyawan
    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::user()->nik;

        $histori = DB::table('presensi')
            ->join('users', 'presensi.nik', '=', 'users.nik')
            ->whereMonth('presensi.tgl_presensi', '=', $bulan)
            ->whereYear('presensi.tgl_presensi', '=', $tahun)
            ->where('presensi.nik', '=', $nik)
            ->orderBy('presensi.tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }
}
