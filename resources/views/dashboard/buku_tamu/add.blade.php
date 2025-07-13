@extends('dashboard.layouts.app')

@section('content')
    <form action="{{ route('data-tamu.storeAdmin') }}" method="post">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nama" class="form-label">Nama Tamu</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama tamu"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="number" name="telepon" id="telepon"
                                class="form-control @error('telepon') is-invalid @enderror" placeholder="Nomor telepon"
                                value="{{ old('telepon') }}">
                            @error('telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" id="alamat"
                                class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat tamu"
                                value="{{ old('alamat') }}">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="instansi" class="form-label">Instansi/Lembaga</label>
                            <input type="text" name="instansi" id="instansi"
                                class="form-control @error('instansi') is-invalid @enderror" placeholder="Instansi/lembaga"
                                value="{{ old('instansi') }}">
                            @error('instansi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="instansi" class="form-label">Staf Yang Ingin Ditemui</label>
                            <select name="id_staf" id="id_staf" class="form-select select2">
                                <option value="">-- Pilih Staft Yang Ingin Ditemui --</option>
                                @foreach ($stafs as $staf)
                                    <option value="{{ $staf->id }}">{{ $staf->nama . ' - ' . $staf->jabatan }}</option>
                                @endforeach
                            </select>
                            @error('id_staf')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tgl_kunjungan" class="form-label">Tanggal Kunjungan</label>
                            <input type="datetime-local" name="tgl_kunjungan" id="tgl_kunjungan"
                                class="form-control @error('tgl_kunjungan') is-invalid @enderror"
                                value="{{ old('tgl_kunjungan') }}">
                            @error('tgl_kunjungan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" cols="30" rows="5"
                                class="form-control @error('keperluan') is-invalid @enderror" placeholder="Keperluan">{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="informasi" class="form-label">Informasi Dibutuhkan</label>
                            <textarea name="informasi" id="informasi" cols="30" rows="5" class="form-control" placeholder="informasi">{{ old('informasi') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="form-label" for="is_janji">Sudah Buat Janji</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input @error('is_janji') is-invalid @enderror" type="radio"
                                name="is_janji" id="is_janji2" value="0"
                                {{ old('is_janji') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_janji2">
                                Belum
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('is_janji') is-invalid @enderror" type="radio"
                                name="is_janji" id="is_janji1" value="1"
                                {{ old('is_janji') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_janji1">
                                Sudah
                            </label>
                        </div>
                    </div>
                    @error('is_janji')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="mb-3">
            <a href="{{ route('data-tamu.index') }}" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary float-end">Simpan</button>
        </div>
    </form>
@endsection
