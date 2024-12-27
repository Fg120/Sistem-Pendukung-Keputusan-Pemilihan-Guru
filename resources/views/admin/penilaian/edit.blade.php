@extends('admin.layouts.app')

@push('css')
@endpush

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://parsleyjs.org/dist/parsley.min.js"></script>
    <script src="{{ asset('assets/admin/static/js/pages/parsley.js') }}"></script>
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Penilaian</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.penilaian.index') }}">Penilaian</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Penilaian</h4>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route('admin.penilaian.update', Crypt::encrypt($alternatifs->id)) }}" method="POST" data-parsley-validate>
                                    @csrf<div class="row">
                                        <div class="col-md-6 col-12">
                                            <fieldset class="form-group">
                                                <label for="alternatif-column" class="form-label">Alternatif</label>
                                                <select class="form-select" id="alternatif-column" disabled>
                                                    <option value="">{{ $alternatifs->nama }}</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($kriterias as $item)
                                            <div class="col-md-6 col-12">
                                                <fieldset class="form-group mandatory">
                                                    <label for="{{ $item->nama }}-column" class="form-label">{{ $item->nama }}</label>
                                                    <select class="form-select" id="{{ $item->sys_name }}-column" name="{{ $item->id }}_{{ $item->sys_name }}_id" required>
                                                        <option value="">Silahkan Pilih {{ $item->sys_name }}</option>
                                                        @foreach ($item->sub as $i)
                                                            @if (isset($data[$item->id]))
                                                                <option value="{{ $i->id }}" {{ $data[$item->id] == $i->id ? 'selected' : '' }}>{{ $i->nama }}</option>
                                                            @else
                                                                <option value="{{ $i->id }}">{{ $i->nama }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                @error('user_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
