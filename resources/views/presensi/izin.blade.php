@extends('layouts.presensi')
@section('header')

<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Izin/Sakit</div>
    <div class="right"></div>
</div>

<style>
    .historicontent {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .dataabsen {
        flex-grow: 1;
    }

    .status {
        position: absolute;
        right: 1rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-sakit { background: #fecaca; color: #dc2626; }
    .status-izin { background: #fef3c7; color: #d97706; }
    .status-cuti { background: #bbf7d0; color: #15803d; }

    .izin-card {
        background: white;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .izin-date {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .izin-type {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .izin-desc {
        color: #4b5563;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
</style>

@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <div class="section-title">Riwayat Izin</div>
        <div class="card">
            <div class="card-body">
                @if($dataizin->isEmpty())
                <div class="empty-state">
                    <ion-icon name="document-text-outline" class="empty-icon"></ion-icon>
                    <p>Belum ada data pengajuan izin</p>
                </div>
                @else
                @foreach($dataizin as $d)
                <div class="izin-card">
                    <div class="izin-date">
                        <ion-icon name="calendar-outline"></ion-icon>
                        {{ date('d-m-Y', strtotime($d->tgl_izin)) }}
                    </div>
                    <div class="izin-type">
                        @if($d->status == 's')
                        <div class="status-badge status-sakit">
                            <ion-icon name="medkit-outline"></ion-icon> Sakit
                        </div>
                        @elseif($d->status == 'i')
                        <div class="status-badge status-izin">
                            <ion-icon name="document-text-outline"></ion-icon> Izin
                        </div>
                        @else
                        <div class="status-badge status-cuti">
                            <ion-icon name="calendar-outline"></ion-icon> Cuti
                        </div>
                        @endif
                    </div>
                    <div class="izin-desc">
                        <ion-icon name="chatbox-outline"></ion-icon>
                        {{ $d->keterangan }}
                    </div>
                    <div class="izin-status">
                        @if($d->status_approved == 0)
                        <span class="badge bg-warning">Menunggu</span>
                        @elseif($d->status_approved == 1)
                        <span class="badge bg-success">Disetujui</span>
                        @else
                        <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<div class="fab-button bottom-right" style="margin-bottom:70px">
    <a href="/presensi/buatizin" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection
