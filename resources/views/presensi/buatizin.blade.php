@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin</div>
    <div class="right"></div>
</div>

@endsection
@section('content')
<div class="row" style="margin-top:70px; margin-bottom:30px;">
    <div class="col s12 m8 l6 offset-m2 offset-l3">
        <div class="card">
            <div class="card-content">
                <span class="card-title center-align">Pengajuan Izin</span>
                <form method="POST" action="/presensi/storeizin" id="frmIzin">
                    @csrf
                    <!-- Input Tanggal -->
                    <div class="input-field" style="margin-bottom: 25px;">
                        <input type="text" id="tanggal_izin" name="tgl_izin" class="datepicker">
                        <label for="tanggal">Tanggal</label>
                    </div>
                    <!-- Dropdown Status -->
                    <div class="input-field" style="margin-bottom: 25px;">
                        <select name="status" id="status">
                            <option value="" disabled selected>Pilih Jenis Izin</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                            <option value="c">Cuti</option> <!-- Opsi baru untuk cuti -->
                        </select>
                        <label for="status">Status</label>
                    </div>
                    <!-- Textarea Keterangan -->
                    <div class="input-field" style="margin-bottom: 25px;">
                        <textarea id="keterangan" name="keterangan" class="materialize-textarea" style="min-height: 150px;"></textarea>
                        <label for="keterangan">Keterangan</label>
                    </div>
                    <!-- Submit Button -->
                    <div class="center-align" style="margin-top:30px;">
                        <button type="submit" class="btn waves-effect waves-light blue">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize datepicker
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, {
            format: 'yyyy-mm-dd',
            yearRange: [1900, new Date().getFullYear()]
        });

        // Initialize select dropdown
        var selects = document.querySelectorAll('select');
        M.FormSelect.init(selects);

        $("#frmIzin").submit(function() {
            var tanggal_izin = $("#tanggal_izin").val();
            var status = $("#status").val();
            var keterangan = $("#keterangan").val();
            if(tanggal_izin==""){
                Swal.fire({
                        title: 'Maaf',
                        text: 'Tanggal Harus Diisi',
                        icon: 'warning'
                });
                return false;
            } else if(status==""){
                Swal.fire({
                        title: 'Maaf',
                        text: 'Status Harus Diisi',
                        icon: 'warning'
                });
                return false;
            } else if(keterangan==""){
                Swal.fire({
                        title: 'Maaf',
                        text: 'Keterangan Harus Diisi',
                        icon: 'warning'
                });
                return false;
            }
        });
    });
</script>
@endpush
