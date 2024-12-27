@extends('public.layouts.app')

@push('css')
@endpush
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hasil-table').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                info: false,
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
    <section id="hero" class="hero section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12">
                    <h2>Hasil Akhir</h2>
                </div>
                <div class="col-12 card">
                    <div class="card-body">
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
        </div>
    </section>
@endsection
