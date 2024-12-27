@extends('admin.layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/scss/pages/datatables.scss') }}">
@endpush
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.matrix-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'matrix') }}",
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    @foreach ($kriterias as $column)
                        {
                            data: '{{ $column['sys_name'] }}',
                            name: '{{ $column['sys_name'] }}'
                        },
                    @endforeach
                ]
            });
            $('.bobot-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'bobot') }}",
                columns: [
                    @foreach ($kriterias as $column)
                        {
                            data: '{{ $column['sys_name'] }}',
                            name: '{{ $column['sys_name'] }}'
                        },
                    @endforeach
                ]
            });
            $('.normalisasi-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'normalisasi') }}",
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    @foreach ($kriterias as $column)
                        {
                            data: '{{ $column['sys_name'] }}',
                            name: '{{ $column['sys_name'] }}'
                        },
                    @endforeach
                ]
            });
            $('.normalisasi-bobot-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'normalisasi-bobot') }}",
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    @foreach ($kriterias as $column)
                        {
                            data: '{{ $column['sys_name'] }}',
                            name: '{{ $column['sys_name'] }}'
                        },
                    @endforeach
                ]
            });
            $('.solusi-ideal-positif-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'solusi-ideal-positif') }}",
                columns: [
                    @foreach ($kriterias as $column)
                        {
                            data: '{{ $column['sys_name'] }}',
                            name: '{{ $column['sys_name'] }}'
                        },
                    @endforeach
                ]
            });
            $('.solusi-ideal-negatif-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'solusi-ideal-negatif') }}",
                columns: [
                    @foreach ($kriterias as $column)
                        {
                            data: '{{ $column['sys_name'] }}',
                            name: '{{ $column['sys_name'] }}'
                        },
                    @endforeach
                ]
            });
            $('#d-positif-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'd-positif') }}",
                columns: [{
                    data: 'nama',
                    name: 'nama'
                }, {
                    data: 'nilai',
                    name: 'nilai'
                }, ]
            });
            $('.d-negatif-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'd-negatif') }}",
                columns: [{
                    data: 'nama',
                    name: 'nama'
                }, {
                    data: 'nilai',
                    name: 'nilai'
                }, ]
            });
            $('.hasil-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.data_penilaian.data', 'hasil') }}",
                columns: [{
                    data: 'nama',
                    name: 'nama'
                }, {
                    data: 'nilai',
                    name: 'nilai'
                }, {
                    data: 'rank',
                    name: 'rank'
                }, ]
            });
        });
    </script>
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Perhitungan</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Perhitungan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Alternatif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table matrix-table" id="matrix-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    @foreach ($kriterias as $i)
                                        <th>{{ $i->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Bobot
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bobot-table" id="bobot-table">
                            <thead>
                                <tr>
                                    @foreach ($kriterias as $i)
                                        <th>{{ $i->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Normalisasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table normalisasi-table" id="normalisasi-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    @foreach ($kriterias as $i)
                                        <th>{{ $i->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Keputusan Ternormalisasi dan Terbobot
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table normalisasi-bobot-table" id="normalisasi-bobot-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    @foreach ($kriterias as $i)
                                        <th>{{ $i->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Solusi Ideal Positif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table solusi-ideal-positif-table" id="solusi-ideal-positif-table">
                            <thead>
                                <tr>
                                    @foreach ($kriterias as $i)
                                        <th>{{ $i->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Solusi Ideal Negatif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table solusi-ideal-negatif-table" id="solusi-ideal-negatif-table">
                            <thead>
                                <tr>
                                    @foreach ($kriterias as $i)
                                        <th>{{ $i->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data D Positif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table d-positif-table" id="d-positif-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data D Negatif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table d-negatif-table" id="d-negatif-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Hasil
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table hasil-table" id="hasil-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nilai</th>
                                    <th>Rank</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
