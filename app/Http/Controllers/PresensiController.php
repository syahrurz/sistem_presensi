<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('nik', $nik)
            ->count();
        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
{
    try {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;

        // Cari data presensi hari ini berdasarkan NIK dan tanggal presensi
        $presensiHariIni = DB::table('presensi')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)
            ->first();

        if ($presensiHariIni) {
            // Jika sudah ada data, cek apakah presensi pulang sudah dilakukan
            if ($presensiHariIni->jam_out) {
                return "error|Anda sudah melakukan presensi pulang hari ini.";
            }

            // Proses presensi pulang
            $data_pulang = [
                'jam_out' => $jam,
                'lokasi_out' => $lokasi,
                'updated_at' => now()
            ];

            $update = DB::table('presensi')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('nik', $nik)
                ->update($data_pulang);

            if ($update) {
                return "success|Terima kasih, hati-hati di jalan|out";
            } else {
                return "error|Gagal memproses presensi pulang.";
            }
        } else {
            // Proses presensi masuk
            $data = [
                'nik' => $nik,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam,
                'jam_out' => null,
                'lokasi_in' => $lokasi,
                'lokasi_out' => null,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $simpan = DB::table('presensi')->insert($data);

            if ($simpan) {
                return "success|Terima kasih, selamat bekerja|in";
            } else {
                return "error|Gagal memproses presensi masuk.";
            }
        }
    } catch (\Exception $e) {
        return "error|" . $e->getMessage();
    }
}


    public function izin()
    {
        return view('presensi.izin');
    }

    public function buatizin()
    {
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
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

        if($simpan){
            return redirect ('/presensi/izin')->with(['success'=>'Data Berhasil Disimpan']);
        } else {
            return redirect ('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function histori(){

        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('nik', $nik)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistori', compact('histori'));
    }
}


