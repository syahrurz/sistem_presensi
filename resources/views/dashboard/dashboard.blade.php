@extends('layouts.presensi') <!-- Menggunakan layout dasar 'presensi' untuk tampilan halaman -->
@section('content') <!-- Memulai konten dari halaman -->

<!-- Wrapper untuk seluruh konten aplikasi -->
<div id="appCapsule">
    <!-- Section User (Bagian Informasi Pengguna) -->
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar"> <!-- Bagian untuk foto profil pengguna -->
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded"> <!-- Gambar avatar pengguna -->
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::user()->name }}</h2> <!-- Nama pengguna -->
                <span id="user-role">{{ Auth::user()->jabatan }}</span> <!-- Jabatan pengguna -->
                <div id="user-shift" class="mt-1"> <!-- Informasi jam kerja atau shift -->
                    <ion-icon name="time-outline" class="text-info" style="font-size: 1rem; color:white;"></ion-icon>
                    <span class="text-white" style="font-size: 0.9rem;">Shift: {{ Auth::user()->shift ?? 'Tidak Ada Data Shift' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Kehadiran Hari Ini -->
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <!-- Kolom pertama: Status Masuk -->
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon> <!-- Ikon untuk Masuk -->
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4> <!-- Judul "Masuk" -->
                                    <span>{{ $presensihariini ? $presensihariini->jam_in : 'Belum Absen' }}</span> <!-- Menampilkan waktu jam masuk atau status 'Belum Absen' -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kolom kedua: Status Pulang -->
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon> <!-- Ikon untuk Pulang -->
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4> <!-- Judul "Pulang" -->
                                    <span>{{ $presensihariini && $presensihariini->jam_out ? $presensihariini->jam_out : 'Belum Absen' }}</span> <!-- Menampilkan waktu jam pulang atau status 'Belum Absen' -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekap Presensi (Bagian Status Kehadiran) -->
        <div class="rekappresensi">
            <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }} </h3>
            <div class="row text-center justify-content-center">
                <!-- Card 1: Hadir -->
                <div class="col-4 col-sm-2 mb-2">
                    <div class="card">
                        <div class="card-body" style="padding: 10px;">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="body-outline" style="font-size: 1.5rem;" class="text-primary"></ion-icon> <!-- Ikon Hadir -->
                            <br>
                            <span style="font-size: 0.8rem;">Hadir</span> <!-- Teks Hadir -->
                        </div>
                    </div>
                </div>
                <!-- Card 2: Izin -->
                <div class="col-4 col-sm-2 mb-2">
                    <div class="card">
                        <div class="card-body" style="padding: 10px;">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="receipt-outline" style="font-size: 1.5rem;" class="text-success"></ion-icon> <!-- Ikon Izin -->
                            <br>
                            <span style="font-size: 0.8rem;">Izin</span> <!-- Teks Izin -->
                        </div>
                    </div>
                </div>
                <!-- Card 3: Sakit -->
                <div class="col-4 col-sm-2 mb-2">
                    <div class="card">
                        <div class="card-body" style="padding: 10px;">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.5rem;" class="text-danger"></ion-icon> <!-- Ikon Sakit -->
                            <br>
                            <span style="font-size: 0.8rem;">Sakit</span> <!-- Teks Sakit -->
                        </div>
                    </div>
                </div>
                <!-- Card 4: Telat -->
                <div class="col-4 col-sm-2 mb-2">
                    <div class="card">
                        <div class="card-body" style="padding: 10px;">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.5rem;" class="text-warning"></ion-icon> <!-- Ikon Telat -->
                            <br>
                            <span style="font-size: 0.8rem;">Telat</span> <!-- Teks Telat -->
                        </div>
                    </div>
                </div>
                <!-- Card 5: Cuti -->
                <div class="col-4 col-sm-2 mb-2">
                    <div class="card">
                        <div class="card-body" style="padding: 10px;">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="today-outline" style="font-size: 1.5rem;" class="text-primary"></ion-icon> <!-- Ikon Cuti -->
                            <br>
                            <span style="font-size: 0.8rem;">Cuti</span> <!-- Teks Cuti -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Histori Presensi -->
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <!-- Tab Bulan Ini -->
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Bulan Ini</a>
                    </li>
                    <!-- Tab Leaderboard -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Leaderboard</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <!-- Tab Data Bulan Ini -->
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    @if($historibulanini->isEmpty())
                        <p class="text-center">Tidak ada data presensi untuk bulan ini.</p>
                    @else
                        <ul class="listview image-listview">
                            <!-- Menampilkan histori presensi bulanan -->
                            @foreach ($historibulanini as $d)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="calendar-outline"></ion-icon> <!-- Ikon kalender -->
                                        </div>
                                        <div class="in">
                                            <div>{{ $d->tgl_presensi }}</div> <!-- Tanggal presensi -->
                                            <span class="badge badge-success">Masuk: {{ $d->jam_in ?? '-' }}</span> <!-- Jam masuk -->
                                            <span class="badge badge-danger">Pulang: {{ $d->jam_out ?? '-' }}</span> <!-- Jam pulang -->
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Tab Leaderboard -->
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        <!-- Daftar leaderboard -->
                        @foreach ($leaderboard as $d)
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image"> <!-- Foto pengguna -->
                                <div class="in">
                                    <div>
                                        {{ $d->name }}<br>
                                        <small>{{ $d->jabatan }} </small>

                                    </div> <!-- Nama pengguna -->
                                    <span class="badge bg-success">
                                        {{ $d->jam_in }}
                                    </span> <!-- Jabatan pengguna -->
                                </div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
