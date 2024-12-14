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
    <a href="javascript:;" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
