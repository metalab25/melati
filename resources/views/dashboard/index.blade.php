@extends('dashboard.layouts.app')


@push('css')
    <style>
        .card .card-body.tryal {
            padding: 3rem;
        }

        .tryal h2,
        .tryal .h2 {
            font-size: 2rem;
            font-weight: 400;
            color: #fff;
            position: relative;
            z-index: 1;
            font-family: 'Poppins', sans-serif
        }

        .tryal span {
            font-size: 1rem;
            font-weight: 400;
            color: #fff;
            display: block;
            margin: 1.875rem 0;
            position: relative;
            z-index: 1;
        }

        img.sd-shape {
            animation: movedelement 10s linear infinite;
            width: 100%;
            transform: scale(1.1);
            position: relative;
            z-index: 1;
        }

        .small-box p {
            font-weight: 600;
            font-family: 'Poppins', sans-serif
        }

        img.icon-raction {
            width: 40px
        }

        @keyframes movedelement {
            0% {
                -webkit-transform: translate(0);
                transform: translate(0);
            }

            25% {
                -webkit-transform: translate(10px, 10px);
                transform: translate(10px, 10px);
            }

            50% {
                -webkit-transform: translate(5px, 5px);
                transform: translate(5px, 5px);
            }

            75% {
                -webkit-transform: translate(10px, -5px);
                transform: translate(10px, -5px);
            }

            100% {
                -webkit-transform: translate(0);
                transform: translate(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="mb-0 border-0 card tryal-gradient mb-sm-3">
                <div class="card-body tryal row">
                    <div class="col-xl-7 col-sm-6">
                        <h2>SIMELATI - DINSOS NTB</h2>
                        <span>Sistem Informasi Melayani Dengan Hati Dinas Sosial Nusa Tenggara Barat (NTB)</span>
                    </div>
                    <div class="col-xl-5 col-sm-6">
                        <img src="{{ asset('assets/img/service.png') }}" alt="" class="img-fluid sd-shape">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <p>Total Tamu</p>
                            <h3>{{ $tamuAllCount }}</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 16 16"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <p>Tamu Hari Ini</p>
                            <h3>{{ $tamuToday }}</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 16 16"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <p>Jumlah Staf</p>
                            <h3>{{ $stafsAll }}</h3>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 16 16"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-0 card">
        <div class="card-body">
            <div class="table-responsive table-shadow rounded-3">
                <table class="table mb-0 table-striped table-bordered justify-content-center">
                    <thead>
                        <tr>
                            <th class="text-center align-middle" width="2%">No.</th>
                            <th class="text-center align-middle">Nama Tamu</th>
                            <th class="text-center align-middle">Instansi</th>
                            <th class="text-center align-middle">Tujuan</th>
                            <th class="text-center align-middle">Waktu Kunjungan</th>
                            <th class="text-center align-middle">Reaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tamus as $index => $item)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="align-middle">
                                    {{ $item->nama }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $item->instansi }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $item->staf->nama }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ \Carbon\Carbon::parse($item->tgl_kunjungan)->translatedFormat('d F Y H:i:s') }}
                                </td>
                                <td class="text-center align-middle">
                                    @if ($item->reaction == null)
                                        -
                                    @elseif ($item->reaction == 1)
                                        <img src="{{ asset('assets/img/emoticon/sangat_tidak_puas.webp') }}" alt=""
                                            class="img-fluid icon-raction">
                                    @elseif ($item->reaction == 2)
                                        <img src="{{ asset('assets/img/emoticon/tidak_puas.webp') }}" alt=""
                                            class="img-fluid icon-raction">
                                    @elseif ($item->reaction == 3)
                                        <img src="{{ asset('assets/img/emoticon/baik.webp') }}" alt=""
                                            class="img-fluid icon-raction">
                                    @elseif ($item->reaction == 4)
                                        <img src="{{ asset('assets/img/emoticon/sangat_baik.webp') }}" alt=""
                                            class="img-fluid icon-raction">
                                    @elseif ($item->reaction == 5)
                                        <img src="{{ asset('assets/img/emoticon/puas.webp') }}" alt=""
                                            class="img-fluid icon-raction">
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center align-middle" colspan="7">Data tidak ditemukan</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
