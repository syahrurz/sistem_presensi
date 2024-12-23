<li class="nav-item">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
        <ion-icon name="log-out-outline"></ion-icon>
        <span>Logout</span>
    </a>
</li>

<form id="logout-form" action="{{ route('proseslogout') }}" method="POST" style="display: none;">
    @csrf
</form>
