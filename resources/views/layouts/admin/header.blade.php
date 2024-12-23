<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="material-icons">logout</i> Logout
</a>

<form id="logout-form" action="/proseslogout" method="POST" style="display: none;">
    @csrf
</form>
