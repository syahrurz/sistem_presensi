@extends('layouts.presensi')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Histori Presensi</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="">Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                            {{ $namabulan[$i] }}
                        </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Tahun</option>
                        @php
                            $tahunmulai = 2022;
                            $tahunskrg = date('Y');
                        @endphp
                        @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                        <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary btn-block" id="cari">
                        <ion-icon name="search-outline"></ion-icon> Cari
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="showhistori">
        <!-- Data histori akan dimuat di sini -->
    </div>
</div>
@endsection

@push('myscript')
<script>
  $(function() {
    $("#cari").click(function(e) {
        e.preventDefault();
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();

        if (!bulan || !tahun) {
            alert('Harap pilih bulan dan tahun terlebih dahulu.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/gethistori',
            data: {
                _token: "{{ csrf_token() }}",
                bulan: bulan,
                tahun: tahun
            },
            success: function(respond) {
                $("#showhistori").html(respond);
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
            }
        });
    });
  });
</script>
@endpush
