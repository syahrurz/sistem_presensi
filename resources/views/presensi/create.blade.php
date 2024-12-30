@extends('layouts.presensi')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Presensi</div>
    <div class="right"></div>
</div>

<style>
    #map { height: 300px; }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div class="row" style="margin-top: 70px;">
    <div class="col">
        <input type="hidden" id="lokasi">
    </div>
</div>
<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
<div class="row mt-2">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div id="status-lokasi" class="alert alert-warning mb-2" style="display: none;">
                    Mencari lokasi...
                </div>
                @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block" disabled>Presensi Keluar</button>
                @else
                <button id="takeabsen" class="btn btn-primary btn-block" disabled>Presensi Masuk</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kantorLatitude = -7.80653135; // Ganti dengan koordinat kantor Anda
    const kantorLongitude = 110.35040706; // Ganti dengan koordinat kantor Anda
    const lokasi = document.getElementById('lokasi');
    const takeabsenBtn = document.getElementById('takeabsen');
    const statusLokasi = document.getElementById('status-lokasi');
    let map = null;

    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(successCallback, errorCallback, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    }

    function successCallback(position) {
        const userLat = position.coords.latitude;
        const userLong = position.coords.longitude;
        lokasi.value = `${userLat},${userLong}`;

        if (!map) {
            map = L.map('map').setView([userLat, userLong], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Circle radius untuk kantor
            L.circle([kantorLatitude, kantorLongitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.2,
                radius: 300
            }).addTo(map);

            // Marker untuk kantor
            L.marker([kantorLatitude, kantorLongitude]).addTo(map)
                .bindPopup("Lokasi Kantor")
                .openPopup();
        }

        // Marker posisi pengguna
        if (window.userMarker) {
            map.removeLayer(window.userMarker);
        }

        const userIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
            iconSize: [38, 38],
            iconAnchor: [19, 38],
            popupAnchor: [0, -40]
        });

        window.userMarker = L.marker([userLat, userLong], { icon: userIcon }).addTo(map)
            .bindPopup("Lokasi Anda Saat Ini");

        const distance = getDistanceFromLatLonInKm(userLat, userLong, kantorLatitude, kantorLongitude) * 1000;

        if (distance <= 100) {
            takeabsenBtn.disabled = false;
            statusLokasi.className = 'alert alert-success mb-2';
            statusLokasi.innerHTML = 'Anda berada dalam area presensi';
        } else {
            takeabsenBtn.disabled = true;
            statusLokasi.className = 'alert alert-warning mb-2';
            statusLokasi.innerHTML = `Anda berada di luar area presensi (${Math.round(distance)} meter dari lokasi)`;
        }
        statusLokasi.style.display = 'block';
    }

    function errorCallback(error) {
        Swal.fire({
            title: 'Error!',
            text: 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin lokasi diberikan.',
            icon: 'error'
        });
    }

    takeabsenBtn.addEventListener('click', function(e) {
        e.preventDefault();

        if (!lokasi.value) {
            Swal.fire({
                title: 'Error!',
                text: 'Lokasi belum terdeteksi. Mohon tunggu sebentar.',
                icon: 'error'
            });
            return;
        }

        takeabsenBtn.disabled = true;
        takeabsenBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

        $.ajax({
            type: 'POST',
            url: '/presensi/store',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                lokasi: lokasi.value
            },
            cache: false,
            success: function(response) {
                takeabsenBtn.disabled = false;
                takeabsenBtn.innerHTML = 'Presensi Masuk';

                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/dashboard';
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function() {
                takeabsenBtn.disabled = false;
                takeabsenBtn.innerHTML = 'Presensi Masuk';

                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memproses presensi.',
                    icon: 'error',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius bumi dalam km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
});
</script>
@endpush
