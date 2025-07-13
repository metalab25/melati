<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            margin-top: 0;
            color: #555;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 0.9em;
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
    </style>
</head>

<body class="py-4 px-2">
    <div class="header mb-4">
        <h2>Laporan Buku Tamu</h2>
        <h3>{{ $title }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Instansi</th>
                <th>Ingin Bertemu</th>
                <th>Waktu Kunjungan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->telepon }}</td>
                    <td>{{ $item->instansi ?? '-' }}</td>
                    <td>{{ $item->staf->nama }}</td>
                    <td>{{ $item->created_at->translatedFormat('d F Y H:i:s') }}</td>
                    <td class="text-center">
                        @if ($item->status == 1)
                            <span style="color: green;">✓ Selesai</span>
                        @else
                            <span style="color: orange;">Belum</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}</p>

    <button onclick="window.print()" class="no-print btn btn-dark m-3 float-end">
        Cetak Data
    </button>

    {{-- <script>
        window.onload = function() {
            window.print();
        }
    </script> --}}
</body>

</html>
