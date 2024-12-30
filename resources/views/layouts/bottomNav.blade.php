<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="/dashboard" class="item {{ request()-> is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Beranda</strong>
        </div>
    </a>
    <a href="/presensi/histori" class="item">
        <div class="col">
            <ion-icon name="time-outline"></ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
    <a href="/presensi/create" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="location" role="img" class="md hydrated" aria-label="location"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/presensi/izin" class="item">
        <div class="col">
            <ion-icon name="clipboard-outline" role="img" class="md hydrated" aria-label="clipboard outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="item">
        <div class="col">
            <ion-icon name="log-out-outline"></ion-icon>
            <strong>Keluar</strong>
        </div>
    </a>
</div>

<!-- Form Logout -->
<form id="logout-form" action="{{ route('proseslogout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!-- * App Bottom Menu -->
