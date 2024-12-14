@if ($histori->isEmpty())
    <p class="text-center">Tidak ada histori presensi untuk bulan dan tahun yang dipilih.</p>
@else
    <ul class="listview image-listview">
        @foreach ($histori as $d)
        <li>
            <div class="item">
                <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="image" class="image"> <!-- Foto pengguna -->
                <div class="in">
                    <div>
                        {{ date("d-m-Y", strtotime($d->tgl_presensi)) }}<br>
                    </div>
                    <span class="badge bg-success">
                        {{ $d->jam_in ?? '-' }}
                    </span>
                    <span class="badge bg-primary">
                        {{ $d->jam_out ?? '-' }}
                    </span>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
@endif
