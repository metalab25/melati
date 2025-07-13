@extends('dashboard.layouts.app')

@push('css')
    <style>
        /* Improved icon sizing */
        img.icon-raction {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        /* Avatar placeholder styling */
        .avatar-placeholder {
            margin: 0 auto;
            width: 150px;
            height: 150px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        /* Table styling */
        .table-responsive {
            overflow-x: auto;
        }

        /* Card header styling */
        .card-header {
            font-weight: 600;
        }

        /* Form control sizing */
        .form-select-sm {
            width: auto;
            display: inline-block;
        }

        /* Search input group */
        .input-group {
            max-width: 400px;
        }
    </style>
@endpush

@section('content')
    <div class="mb-4 row">
        <div class="col-md-6">
            <h4 class="fw-bold">SIMELATI</h4>
            <p class="mb-0 text-muted">Dinas Sosial NTB</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('staf.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="mb-4 card">
        <div class="text-white card-header bg-primary">
            <h5 class="mb-0">Detail Staff</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-4 text-center">
                        @if ($staf->foto)
                            <img src="{{ asset('storage/' . $staf->foto) }}" class="img-thumbnail rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="{{ $staf->nama }}">
                        @else
                            <img src="{{ asset('assets/img/avatar.png') }}" class="img-thumbnail rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="Avatar Default">
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="mb-4 card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Informasi Staff</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4 fw-bold">Nama Lengkap</div>
                                <div class="col-md-8">{{ $staf->nama }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-4 fw-bold">Jabatan</div>
                                <div class="col-md-8">{{ $staf->jabatan }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                                <div class="col-md-8">{{ ucfirst($staf->kelamin) }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-4 fw-bold">Nomor Telepon</div>
                                <div class="col-md-8">{{ $staf->telepon }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Data Tamu Terakhir</h6>
                                <small>Show
                                    <select class="form-select form-select-sm d-inline-block" style="width: auto;">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                    </select> entries
                                </small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Nama Tamu</th>
                                            <th>Instansi</th>
                                            <th width="15%">Waktu Kunjungan</th>
                                            <th width="10%" class="text-center">Reaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentVisitors as $visitor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $visitor->nama }}</td>
                                                <td>{{ $visitor->instansi ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($visitor->tgl_kunjungan)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($visitor->reaction == null)
                                                        -
                                                    @else
                                                        <img src="{{ asset(
                                                            'assets/img/emoticon/' .
                                                                [
                                                                    1 => 'sangat_tidak_puas.webp',
                                                                    2 => 'tidak_puas.webp',
                                                                    3 => 'baik.webp',
                                                                    4 => 'sangat_baik.webp',
                                                                    5 => 'puas.webp',
                                                                ][$visitor->reaction],
                                                        ) }}"
                                                            alt="Reaksi {{ $visitor->reaction }}" class="icon-raction">
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data tamu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search here...">
                                    <button class="btn btn-primary btn-sm" type="button">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
