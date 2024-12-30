@extends('layouts.presensi')
@section('content')

<div id="appCapsule">
    <!-- Section User -->
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::user()->name }}</h2>
                <span id="user-role">{{ Auth::user()->jabatan }}</span>
                <div id="user-shift" class="mt-1">
                    <ion-icon name="time-outline" class="text-info" style="font-size: 1rem; color:white;"></ion-icon>
                    <span class="text-white" style="font-size: 0.9rem;">Shift: {{ Auth::user()->shift ?? 'Tidak Ada Data Shift' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Kehadiran Hari Ini (dengan margin yang disesuaikan) -->
    <div class="section mt-1" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini && $presensihariini->jam_out ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekap Presensi (dengan margin yang disesuaikan) -->
        <div class="rekappresensi mt-1">
            <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
            <div class="row text-center justify-content-center">
                <!-- Card 1: Hadir -->
                <div class="col-4 col-sm-2" style="margin-bottom: 5px;">
                    <div class="card">
                        <div class="card-body" style="padding: 5px !important">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="body-outline" style="font-size: 1.3rem;" class="text-primary"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem;">Hadir</span>
                        </div>
                    </div>
                </div>
                <!-- Card 2: Izin -->
                <div class="col-4 col-sm-2" style="margin-bottom: 5px;">
                    <div class="card">
                        <div class="card-body" style="padding: 5px !important">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="receipt-outline" style="font-size: 1.3rem;" class="text-success"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem;">Izin</span>
                        </div>
                    </div>
                </div>
                <!-- Card 3: Sakit -->
                <div class="col-4 col-sm-2 mb-1">
                    <div class="card">
                        <div class="card-body" style="padding: 8px 8px !important">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.3rem;" class="text-danger"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem;">Sakit</span>
                        </div>
                    </div>
                </div>
                <!-- Card 4: Telat -->
                <div class="col-4 col-sm-2 mb-1">
                    <div class="card">
                        <div class="card-body" style="padding: 8px 8px !important">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.3rem;" class="text-warning"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem;">Telat</span>
                        </div>
                    </div>
                </div>
                <!-- Card 5: Cuti -->
                <div class="col-4 col-sm-2 mb-1">
                    <div class="card">
                        <div class="card-body" style="padding: 8px 8px !important">
                            <span class="badge bg-danger" style="position:absolute; top:3px; left:10px">5</span>
                            <ion-icon name="today-outline" style="font-size: 1.3rem;" class="text-primary"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem;">Cuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Histori Presensi -->
        <div class="presencetab mt-1">
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
                                            <ion-icon name="calendar-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ $d->tgl_presensi }}</div>
                                            <span class="badge badge-success">Masuk: {{ $d->jam_in ?? '-' }}</span>
                                            <span class="badge badge-danger">Pulang: {{ $d->jam_out ?? '-' }}</span>
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
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>
                                        {{ $d->name }}<br>
                                        <small>{{ $d->jabatan }} </small>

                                    </div>
                                    <span class="badge bg-success">
                                        {{ $d->jam_in }}
                                    </span>
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
