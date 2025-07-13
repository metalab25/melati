@extends('website.layouts.app')
@push('css')
    <style>
        .card .card-header.bg-header {
            background: linear-gradient(180deg, #1a174d 0, #164596 100%) !important;
        }

        .card .card-header h3 {
            font-family: 'Outfit', sans-serif
        }

        img.main-logo {
            display: block;
            width: 120px;
        }

        div:where(.swal2-container).swal2-center>.swal2-popup {
            border-radius: 1.5rem !important;
        }

        div:where(.swal2-container) h2:where(.swal2-title) {
            font-weight: 700 !important;
            font-family: 'Outfit', sans-serif !important;
        }

        div:where(.swal2-container) .swal2-html-container {
            font-size: 1em !important;
            font-family: 'Poppins', sans-serif !important;
        }

        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            border-radius: 0.75rem !important;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 mx-auto">
            <form action="{{ route('buku-tamu.store') }}" method="POST">
                @csrf
                <div class="card mb-3">
                    <div class="card-header bg-header text-center p-5">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('assets/img/logo-prov-ntb.png') }}" alt="{{ config('app.name') }}"
                                class="text-center img-fluid main-logo mb-2">
                        </div>
                        <h3 class="text-white mb-0">SIMELATI</h3>
                        <p class="text-white mb-0">Sistem Informasi Melayani Dengan Hati</p>
                        <p class="lead text-white fw-bold mb-0">Dinas Sosial Provinsi Nusa Tenggara Barat</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label class="form-label" for="nama">Nama<span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap"
                                    value="{{ old('nama') }}">
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label" for="telepon">Nomor Telepon<span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="number" name="telepon" id="telepon"
                                    class="form-control @error('telepon') is-invalid @enderror" placeholder="08xxxxxxxxxx"
                                    value="{{ old('telepon') }}">
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('telepon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label" for="alamat">Alamat<span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="alamat" id="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat"
                                    value="{{ old('alamat') }}">
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label" for="instansi">Instansi / Lembaga<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="instansi" id="instansi"
                                    class="form-control @error('instansi') is-invalid @enderror"
                                    placeholder="Instansi/Lembaga" value="{{ old('instansi') }}">
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('instansi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="id_staf" class="form-label">Bertemu Dengan<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <select name="id_staf" id="id_staf"
                                    class="form-control form-select @error('id_staf') is-invalid @enderror">
                                    <option value="">-- Staf Yang Ingin Ditemui --</option>
                                    @foreach ($stafs as $staf)
                                        <option value="{{ $staf->id }}"
                                            {{ old('id_staf') == $staf->id ? 'selected' : '' }}>
                                            {{ $staf->nama . ' - ' . $staf->jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger ps-2">Wajib dipilih</small>
                                @error('id_staf')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label" for="is_janji">Sudah Buat Janji<span
                                    class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-2 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('is_janji') is-invalid @enderror"
                                            type="radio" name="is_janji" id="is_janji2" value="0"
                                            {{ old('is_janji') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_janji2">
                                            Belum
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('is_janji') is-invalid @enderror"
                                            type="radio" name="is_janji" id="is_janji1" value="1"
                                            {{ old('is_janji') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_janji1">
                                            Sudah
                                        </label>
                                    </div>
                                </div>
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('is_janji')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label" for="tgl_kunjungan">Tanggal Kunjungan<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="datetime-local" name="tgl_kunjungan" id="tgl_kunjungan"
                                    class="form-control @error('tgl_kunjungan') is-invalid @enderror"
                                    value="{{ old('tgl_kunjungan') }}">
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('tgl_kunjungan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="form-label" for="keperluan">Keperluan<span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <textarea class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" id="keperluan"
                                    cols="30" rows="3" placeholder="Keperluan">{{ old('keperluan') }}</textarea>
                                <small class="text-danger ps-2">Wajib diisi</small>
                                @error('keperluan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="form-label" for="informasi">Informasi</label>
                            <div class="col-md-12">
                                <textarea class="form-control @error('informasi') is-invalid @enderror" name="informasi" id="informasi"
                                    cols="30" rows="3" placeholder="Informasi"></textarea>
                                @error('informasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    Kirim
                </button>
            </form>
        </div>
    </div>
@endsection
