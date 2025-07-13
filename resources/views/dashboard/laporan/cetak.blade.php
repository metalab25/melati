<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }} | {{ $title }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}" />
    <style>
        body {
            font-family: Arial, sans-serif !important;
        }

        .table> :not(caption)>*>* {
            padding: 0.5rem !important;
            font-size: 0.9em;
        }

        .app-copyright {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 0.95em;
            color: #ccc;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                position: relative;
                min-height: 100vh;
            }

            .container-fluid {
                padding-bottom: 30px;
            }

            .no-print {
                display: none;
            }
        }

        .header-laporan {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-laporan img {
            height: 80px;
            margin-bottom: 10px;
        }

        .info-periode {
            margin-bottom: 15px;
            font-style: italic;
        }

        img.icon-raction {
            width: 40px
        }
    </style>
</head>

<body class="mt-3">
    <div class="container-fluid">
        <div class="row no-print">
            <div class="col-md-12">
                <button onclick="window.print()" class="btn btn-dark float-end">Cetak Laporan Kunjungan</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="header-laporan">
            {{-- <img src="{{ asset('assets/img/logo.png') }}" alt="Logo"> --}}
            <h4 class="mb-1 text-uppercase fw-bold">LAPORAN KUNJUNGAN TAMU</h4>
            <h5 class="mb-1">{{ $title }}</h5>
            <p class="info-periode">
                Periode: {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}
            </p>
        </div>

        <table class="table mb-0 table-striped table-bordered justify-content-center">
            <thead>
                <tr>
                    <th class="text-center align-middle" width="2%">No</th>
                    <th class="text-center align-middle">Nama</th>
                    <th class="text-center align-middle">Alamat</th>
                    <th class="text-center align-middle">Telepon</th>
                    <th class="text-center align-middle">Instansi</th>
                    <th class="text-center align-middle">Ingin Bertemu</th>
                    <th class="text-center align-middle">Waktu Kunjungan</th>
                    <th class="text-center align-middle">Reaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanKunjungan as $index => $laporan)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $laporan->nama }}</td>
                        <td class="align-middle">{{ $laporan->alamat }}</td>
                        <td class="text-center align-middle">{{ $laporan->telepon }}</td>
                        <td class="text-center align-middle">{{ $laporan->instansi }}</td>
                        <td class="text-center align-middle">{{ $laporan->staf->nama }}</td>
                        <td class="text-center align-middle">
                            {{ \Carbon\Carbon::parse($laporan->tgl_kunjungan)->translatedFormat('d F Y H:i:s') }}
                        </td>
                        <td class="text-center align-middle">
                            @if ($laporan->reaction == null)
                                -
                            @elseif ($laporan->reaction == 1)
                                <img src="{{ asset('assets/img/emoticon/sangat_tidak_puas.webp') }}" alt=""
                                    class="img-fluid icon-raction">
                            @elseif ($laporan->reaction == 2)
                                <img src="{{ asset('assets/img/emoticon/tidak_puas.webp') }}" alt=""
                                    class="img-fluid icon-raction">
                            @elseif ($laporan->reaction == 3)
                                <img src="{{ asset('assets/img/emoticon/baik.webp') }}" alt=""
                                    class="img-fluid icon-raction">
                            @elseif ($laporan->reaction == 4)
                                <img src="{{ asset('assets/img/emoticon/sangat_baik.webp') }}" alt=""
                                    class="img-fluid icon-raction">
                            @elseif ($laporan->reaction == 5)
                                <img src="{{ asset('assets/img/emoticon/puas.webp') }}" alt=""
                                    class="img-fluid icon-raction">
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center align-middle" colspan="8">Tidak ada data kunjungan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- <div class="mt-5">
            <table class="table table-borderless">
                <tr>
                    <td class="text-center" width="50%">
                        <p class="mb-5">Mengetahui,</p>
                        <p class="mt-5">_________________________</p>
                        <p>NIP. .........................</p>
                    </td>
                    <td class="text-center" width="50%">
                        <p>{{ config('app.name') }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p class="mt-5">_________________________</p>
                        <p>NIP. .........................</p>
                    </td>
                </tr>
            </table>
        </div> --}}

        <p class="text-xs text-center app-copyright">
            Dokumen ini dicetak menggunakan aplikasi {{ config('app.name') }} pada
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}
        </p>
    </div>
</body>

</html>
