@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <a href="{{ route('data-tamu.create') }}"
                class="btn btn-primary btn-block ms-0 ms-sm-2 mb-2 mb-sm-3 float-end">Tambah
                Tamu</a>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
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
                        <div class="mb-3">
                            <label for="jenisCetak" class="form-label">Jenis Cetak</label>
                            <select class="form-select" id="jenisCetak" name="jenisCetak" required>
                                <option value="bulanan">Bulanan</option>
                                <option value="mingguan">Mingguan</option>
                            </select>
                        </div>
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
                                    `<small class="text-danger d-block mt-1">${value}</small>`
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
@endpush
