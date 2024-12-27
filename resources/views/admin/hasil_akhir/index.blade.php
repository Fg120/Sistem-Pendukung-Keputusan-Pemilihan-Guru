@extends('admin.layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <style>
        @media print {
            #hasil_akhirs-dataTables_wrapper {
                display: initial !important;
                overflow: visible !important;
            }

            .dataTables_scrollBody {
                max-height: none !important;
            }
        }
    </style>
@endpush
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hasil_akhirs-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.hasil_akhir.data') }}",
                columns: [{
                    data: 'nama',
                    name: 'nama',
                }, {
                    data: 'nilai',
                    name: 'nilai',
                }, {
                    data: 'rank',
                    name: 'rank',
                }]
            });
        });
    </script>
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Hasil Akhir</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hasil Akhir</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data Hasil Akhir
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table hasil_akhirs-table" id="hasil_akhirs-table">
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
