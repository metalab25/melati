@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-block mb-2 mb-sm-3 btn-add float-end">Tambah Staf</button>
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
                url: `{{ url('staf/create') }}`,
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
                        window.LaravelDataTables["staf-table"].ajax.reload()
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

        // function updateStatus(id) {
        //     $.ajax({
        //         method: 'POST',
        //         url: `{{ url('staf/update-status') }}/${id}`,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        //         },
        //         success: function(res) {
        //             window.LaravelDataTables["staf-table"].ajax.reload()
        //             showToast(res.message || 'Status updated successfully!')
        //         },
        //         error: function(res) {
        //             showToast(
        //                 res.responseJSON?.message || 'An error occurred!',
        //                 'danger'
        //             )
        //         }
        //     })
        // }

        $('#staf-table').on('click', '.action', function() {
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
                            url: `{{ url('staf/') }}/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr(
                                    'content')
                            },
                            success: function(res) {
                                window.LaravelDataTables["staf-table"].ajax.reload()
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

            // if (jenis == 'status') {
            //     updateStatus(id)
            //     return
            // }

            $.ajax({
                method: 'get',
                url: `{{ url('staf/') }}/${id}/edit`,
                success: function(res) {
                    $('#modalAction').find('.modal-dialog').html(res)
                    modal.show()
                    store()
                }
            })

        });

        function previewFoto() {
            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('.foto-preview');

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onLoad = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }

            const blob = URL.createObjectURL(foto.files[0]);
            imgPreview.src = blob;
        }
    </script>
@endpush
