@extends('dashboard.layouts.app')

@push('css')
    <style>
        img.icon-raction {
            width: 40px
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <button type="button" class="mb-2 btn btn-info btn-block ms-0 ms-sm-2 mb-sm-3 btn-cetak float-end"
                data-jenis="bulanan">Cetak Data Bulanan</button>
            <button type="button" class="mb-2 btn btn-success btn-block ms-0 ms-sm-2 mb-sm-3 btn-cetak float-end"
                data-jenis="mingguan">Cetak Data Mingguan</button>
        </div>
    </div>
    <div class="mb-3 card">

        <div class="card-body">
            <div class="table-responsive table-shadow rounded-3">
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
                                <td class="text-center align-middle">
                                    {{ $laporanKunjungan->firstItem() + $index }}
                                </td>
                                <td class="align-middle">
                                    {{ $laporan->nama }}
                                </td>
                                <td class="align-middle">
                                    {{ $laporan->alamat }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $laporan->telepon }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $laporan->instansi }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $laporan->staf->nama }}
                                </td>
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
                                <td class="text-center align-middle" colspan="9">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3 mb-0 float-end">
        {{ $laporanKunjungan->links() }}
    </div>

    <div class="modal fade" id="modalAction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalActionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        </div>
    </div>

    <!-- Modal Filter Cetak -->
    <div class="modal fade" id="modalFilterCetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalFilterCetakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilterCetakLabel">Cetak Data</h5>
                </div>
                <div class="modal-body">
                    <form id="formFilterCetak">
                        {{-- <div class="mb-3">
                            <label for="jenisCetak" class="form-label">Jenis Cetak</label>
                            <select class="form-select" id="jenisCetak" name="jenisCetak" required>
                                <option value="bulanan">Bulanan</option>
                                <option value="mingguan">Mingguan</option>
                            </select>
                        </div> --}}
                        <div class="mb-3" id="bulanField">
                            <label for="bulan" class="form-label">Pilih Bulan</label>
                            <input type="month" class="form-control" id="bulan" name="bulan" required>
                        </div>
                        <div class="mb-3 d-none" id="mingguField">
                            <label for="minggu" class="form-label">Pilih Minggu</label>
                            <input type="week" class="form-control" id="minggu" name="minggu">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnCetak">Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFilterCetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalFilterCetakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilterCetakLabel">Filter Cetak Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formFilterCetak">
                        <input type="hidden" id="jenisCetak" name="jenisCetak" value="bulanan">

                        <div class="mb-3" id="bulanField">
                            <label for="bulan" class="form-label">Pilih Bulan</label>
                            <input type="month" class="form-control" id="bulan" name="bulan" required>
                        </div>

                        <div class="mb-3 d-none" id="mingguField">
                            <label for="minggu" class="form-label">Pilih Minggu</label>
                            <input type="week" class="form-control" id="minggu" name="minggu">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnCetak">Cetak</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('body').addClass('sidebar-collapse');
        });

        $(function() {
            $('.btn-cetak').on('click', function() {
                const jenisCetak = $(this).data('jenis');
                const modalCetak = new bootstrap.Modal($('#modalFilterCetak'));

                // Reset form
                $('#formFilterCetak')[0].reset();
                $('#jenisCetak').val(jenisCetak);

                if (jenisCetak === 'bulanan') {
                    $('#bulanField').removeClass('d-none');
                    $('#mingguField').addClass('d-none');
                    $('#bulan').val(new Date().toISOString().slice(0, 7));
                } else {
                    $('#mingguField').removeClass('d-none');
                    $('#bulanField').addClass('d-none');

                    // Set default to current week
                    const today = new Date();
                    const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
                    const formattedDate = formatDateForWeekInput(firstDay);
                    $('#minggu').val(formattedDate);
                }

                modalCetak.show();
            });

            $('#btnCetak').on('click', function() {
                const jenisCetak = $('#jenisCetak').val();
                let url = "{{ route('laporan-kunjungan.cetak') }}";

                if (jenisCetak === 'bulanan') {
                    const bulan = $('#bulan').val();
                    if (!bulan) {
                        alert('Silakan pilih bulan terlebih dahulu');
                        return;
                    }
                    url += `?jenis=bulanan&bulan=${bulan}`;
                } else {
                    const minggu = $('#minggu').val();
                    if (!minggu) {
                        alert('Silakan pilih minggu terlebih dahulu');
                        return;
                    }
                    url += `?jenis=mingguan&minggu=${minggu}`;
                }

                window.open(url, '_blank');
                $('#modalFilterCetak').modal('hide');
            });

            function formatDateForWeekInput(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-W${getWeekNumber(date)}`;
            }

            function getWeekNumber(d) {
                d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
                d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
                const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
                const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
                return weekNo < 10 ? '0' + weekNo : weekNo;
            }
        });
    </script>
@endpush

{{-- @push('script')
    {{ $dataTable->scripts() }}

    <script>
        const modal = new bootstrap.Modal($('#modalAction'))
        const toastEl = document.getElementById('liveToast')
        const toast = new bootstrap.Toast(toastEl)

        function showToast(message, type = 'success') {
            const toastBody = toastEl.querySelector('.toast-body')
            toastEl.classList.remove('bg-success', 'bg-danger')
            toastEl.classList.add(`bg-${type}`)
            toastBody.textContent = message
            toast.show()
        }

        $('.btn-add').on('click', function() {
            $.ajax({
                method: 'get',
                url: `{{ url('data-tamu/create') }}`,
                success: function(res) {
                    $('#modalAction').find('.modal-dialog').html(res)
                    modal.show()
                    store()
                }
            })
        })

        function store() {
            $('#formAction').on('submit', function(e) {
                e.preventDefault()
                const _form = this
                const formData = new FormData(_form)

                const url = this.getAttribute('action')

                $.ajax({
                    method: 'POST',
                    url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        window.LaravelDataTables["bukutamu-table"].ajax.reload()
                        modal.hide()
                        showToast(res.message || 'Staf created successfully!')
                    },
                    error: function(res) {
                        let errors = res.responseJSON?.errors
                        $(_form).find('.text-danger.d-block.mt-1').remove()
                        if (errors) {
                            for (const [key, value] of Object.entries(errors)) {
                                $(`[name='${key}']`).parent().append(
                                    `<small class="mt-1 text-danger d-block">${value}</small>`
                                )
                            }
                        }
                        showToast(
                            res.responseJSON?.message || 'An error occurred!',
                            'danger'
                        )
                    }
                })
            })
        }

        function updateStatus(id) {
            $.ajax({
                method: 'POST',
                url: `{{ url('data-tamu/update-status') }}/${id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                success: function(res) {
                    window.LaravelDataTables["bukutamu-table"].ajax.reload()
                    showToast(res.message || 'Status updated successfully!')
                },
                error: function(res) {
                    showToast(
                        res.responseJSON?.message || 'An error occurred!',
                        'danger'
                    )
                }
            })
        }

        $('#bukutamu-table').on('click', '.action', function() {
            let data = $(this).data()
            let id = data.id
            let jenis = data.jenis

            if (jenis == 'delete') {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            url: `{{ url('data-tamu/') }}/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr(
                                    'content')
                            },
                            success: function(res) {
                                window.LaravelDataTables["bukutamu-table"].ajax.reload()
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                            }
                        })

                    }
                });
                return
            }

            if (jenis == 'status') {
                updateStatus(id)
                return
            }

            $.ajax({
                method: 'get',
                url: `{{ url('data-tamu/') }}/${id}/edit`,
                success: function(res) {
                    $('#modalAction').find('.modal-dialog').html(res)
                    modal.show()
                    store()
                }
            })

        });

        $('.btn-cetak').on('click', function() {
            const jenisCetak = $(this).data('jenis');
            const modalCetak = new bootstrap.Modal($('#modalFilterCetak'));

            $('#jenisCetak').val(jenisCetak);

            if (jenisCetak === 'bulanan') {
                $('#bulanField').removeClass('d-none');
                $('#mingguField').addClass('d-none');
                $('#bulan').val(new Date().toISOString().slice(0, 7));
            } else {
                $('#mingguField').removeClass('d-none');
                $('#bulanField').addClass('d-none');
                const today = new Date();
                const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
                const lastDay = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                $('#minggu').val(getWeekNumber(firstDay));
            }

            modalCetak.show();
        });

        $('#jenisCetak').on('change', function() {
            if ($(this).val() === 'bulanan') {
                $('#bulanField').removeClass('d-none');
                $('#mingguField').addClass('d-none');
            } else {
                $('#mingguField').removeClass('d-none');
                $('#bulanField').addClass('d-none');
            }
        });

        $('#btnCetak').on('click', function() {
            const jenisCetak = $('#jenisCetak').val();
            let url = '';

            if (jenisCetak === 'bulanan') {
                const bulan = $('#bulan').val();
                if (!bulan) {
                    showToast('Silakan pilih bulan terlebih dahulu', 'danger');
                    return;
                }
                url = `{{ route('buku-tamu.cetak') }}?jenis=bulanan&bulan=${bulan}`;
            } else {
                const minggu = $('#minggu').val();
                if (!minggu) {
                    showToast('Silakan pilih minggu terlebih dahulu', 'danger');
                    return;
                }
                url = `{{ route('buku-tamu.cetak') }}?jenis=mingguan&minggu=${minggu}`;
            }

            window.open(url, '_blank');
            $('#modalFilterCetak').modal('hide');
        });

        function getWeekNumber(d) {
            d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
            d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
            const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
            const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
            return d.getUTCFullYear() + '-W' + (weekNo < 10 ? '0' + weekNo : weekNo);
        }
    </script>
@endpush --}}
