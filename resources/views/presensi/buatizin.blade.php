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

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card-content {
        padding: 24px !important;
    }

    .card-title {
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        color: #333;
        margin-bottom: 20px !important;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f1f1;
    }

    .input-field {
        margin-bottom: 30px !important;
    }

    .input-field label {
        color: #666;
    }

    .input-field input[type=text],
    .input-field select,
    .input-field textarea {
        border: 1px solid #ddd !important;
        padding: 8px 15px !important;
        border-radius: 8px !important;
        box-sizing: border-box !important;
    }

    .input-field input[type=text]:focus,
    .input-field select:focus,
    .input-field textarea:focus {
        border-color: #1E74FD !important;
        box-shadow: 0 0 0 1px #1E74FD !important;
    }

    .btn {
        border-radius: 10px;
        padding: 0 35px;
        height: 45px;
        line-height: 45px;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        text-transform: none;
    }

    .datepicker-modal {
        border-radius: 15px;
    }

    .select-wrapper input.select-dropdown {
        padding-left: 15px !important;
        border-radius: 8px !important;
        border: 1px solid #ddd !important;
    }

    .select-wrapper input.select-dropdown:focus {
        border-color: #1E74FD !important;
    }

    textarea {
        min-height: 120px !important;
        border-radius: 8px !important;
    }
</style>
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title center-align">
                    <ion-icon name="document-text-outline" style="font-size: 24px; color: #1E74FD;"></ion-icon>
                    <div style="margin-top: 8px;">Pengajuan Izin</div>
                </span>

                <form method="POST" action="/presensi/storeizin" id="frmIzin">
                    @csrf
                    <!-- Input Tanggal -->
                    <div class="input-field">
                        <input type="text" id="tanggal_izin" name="tgl_izin" class="datepicker" readonly>
                        <label for="tanggal">Tanggal</label>
                    </div>

                    <!-- Dropdown Status -->
                    <div class="input-field">
                        <select name="status" id="status">
                            <option value="" disabled selected>Pilih Jenis Izin</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                            <option value="c">Cuti</option>
                        </select>
                        <label>Status</label>
                    </div>

                    <!-- Textarea Keterangan -->
                    <div class="input-field">
                        <textarea id="keterangan" name="keterangan" class="materialize-textarea"></textarea>
                        <label for="keterangan">Keterangan</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="center-align">
                        <button type="submit" class="btn waves-effect waves-light blue">
                            <ion-icon name="send-outline" style="vertical-align: middle; margin-right: 8px;"></ion-icon>
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
        const today = new Date();
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, {
            format: 'yyyy-mm-dd',
            defaultDate: today,
            minDate: today,
            setDefaultDate: true,
            autoClose: true,
            firstDay: 1,
            i18n: {
                months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                weekdays: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                weekdaysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                weekdaysAbbrev: ['M', 'S', 'S', 'R', 'K', 'J', 'S']
            }
        });

        // Initialize select
        var selects = document.querySelectorAll('select');
        M.FormSelect.init(selects);

        // Form validation
        $("#frmIzin").submit(function() {
            var tanggal_izin = $("#tanggal_izin").val();
            var status = $("#status").val();
            var keterangan = $("#keterangan").val();

            if(!tanggal_izin) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Tanggal harus diisi',
                    icon: 'warning'
                });
                return false;
            }
            if(!status) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Status harus dipilih',
                    icon: 'warning'
                });
                return false;
            }
            if(!keterangan) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Keterangan harus diisi',
                    icon: 'warning'
                });
                return false;
            }
        });
    });
</script>
@endpush
