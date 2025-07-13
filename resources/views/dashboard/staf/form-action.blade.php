<div class="modal-content">
    <form id="formAction" action="{{ $staf->id ? route('staf.update', $staf->id) : route('staf.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @if ($staf->id)
            @method('PUT')
        @endif
        <div class="modal-header">
            <h1 class="modal-title fs-6" id="modalActionLabel">{{ $title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="oldFoto" value="{{ $staf->photo }}">
                        @if ($staf->foto)
                            <img src="{{ asset('storage/' . $staf->foto) }}"
                                class="foto-preview img-fluid rounded-3 d-block mx-auto mb-3">
                        @else
                            <img src="{{ asset('/assets/img/avatar.png') }}"
                                class="foto-preview img-fluid rounded-3 d-block mx-auto mb-3">
                        @endif
                    </div>
                    <div class="mb-0">
                        <div class="input-group">
                            <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                name="foto" id="foto" onchange="previewFoto()">
                        </div>
                        @error('foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="nama" id="name" class="form-control" placeholder="Nama Staf"
                            value="{{ old('nama', $staf->nama) }}">
                    </div>
                    <div class="form-group row mb-3">
                        <label class="form-label" for="gender">Jenis Kelamin</label>
                        <div class="row">
                            <div class="col-md-2 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="kelamin" id="genderL" value="Laki-laki"
                                        {{ old('kelamin', $staf->kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderL">
                                        Laki-Laki
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="kelamin" id="genderP" value="Perempuan"
                                        {{ old('kelamin', $staf->kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderP">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            @error('kelamin')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="stafJabatan" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" id="stafJabatan"
                                    class="form-control @error('jabatan') is-invalid @enderror" placeholder="Jabatan"
                                    value="{{ old('jabatan', $staf->jabatan) }}">
                                @error('jabatan')
                                    <div class="invalid-feedback">
                                        {{ 'Jabatan Harus Diisi' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="userPhone" class="form-label">Telepon</label>
                                <input type="number" name="telepon" id="userPhone" class="form-control"
                                    placeholder="081234567890" value="{{ old('telepon', $staf->telepon) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
