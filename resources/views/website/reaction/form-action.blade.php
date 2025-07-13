@extends('website.layouts.app')
@push('css')
    <style>
        h3.app_name {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        .rating-container {
            max-width: 400px;
        }

        .modal-content {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        img.main-logo {
            display: block;
            width: 120px;
        }

        .star-rating {
            direction: rtl;
            display: inline-block;
            padding: 0 20px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #bbb;
            cursor: pointer;
            font-size: 2.5em;
            padding: 5px;
            transition: all 0.3s ease;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: #f7b731;
        }

        .rating-title {
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-family: 'Outfit', sans-serif
        }

        .rating-feedback {
            margin-top: 1.5rem;
            color: #636e72;
        }

        .submit-rating {
            background: linear-gradient(145deg, #f7b731, #f0932b);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            margin-top: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .submit-rating:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 183, 49, 0.4);
        }

        .submit-rating:disabled {
            background: linear-gradient(145deg, #bdc3c7, #95a5a6);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .submit-rating.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .submit-rating .spinner {
            display: none;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .submit-rating.loading .spinner {
            display: block;
        }

        .submit-rating.loading span {
            visibility: hidden;
        }

        #thankyou-message {
            display: none;
            margin-top: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 mx-auto">
            <form id="survey-form" action="{{ route('reaction.submit', ['token' => $token]) }}" method="POST">
                @csrf
                <div class="card mb-3">
                    <div class="card-body p-3 p-sm-4">
                        <div class="text-center rating-container" id="form-content">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('assets/img/logo-prov-ntb.png') }}" alt="{{ config('app.name') }}"
                                    class="text-center img-fluid main-logo mb-2">
                            </div>
                            <h3 class="app_name text-dark mb-0">SIMELATI</h3>
                            <p class="text-muted mb-0">Sistem Informasi Melayani Dengan Hati</p>
                            <p class="lead text-primary fw-bold mb-4">Dinas Sosial Provinsi Nusa Tenggara Barat</p>
                            <h3 class="rating-title">Seberapa puas Anda dengan pelayanan kami?</h3>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="reaction" value="5" required />
                                <label for="star5"><i class="fas fa-grin"></i></label>
                                <input type="radio" id="star4" name="reaction" value="4" />
                                <label for="star4"><i class="fas fa-smile-beam"></i></label>
                                <input type="radio" id="star3" name="reaction" value="3" />
                                <label for="star3"><i class="fas fa-smile"></i></label>
                                <input type="radio" id="star2" name="reaction" value="2" />
                                <label for="star2"><i class="fas fa-meh"></i></label>
                                <input type="radio" id="star1" name="reaction" value="1" />
                                <label for="star1"><i class="fas fa-frown"></i></label>
                            </div>
                        </div>

                        <div id="thankyou-message" class="text-center">
                            <div style="font-size:4rem; color:#27ae60;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div style="font-size:1.2rem; color:#2d3436; margin-bottom:1.5rem;">
                                Terima kasih telah memberikan reaksi terhadai layanan kami!<br>
                                Masukan Anda sangat berarti bagi kami.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 d-flex justify-content-center gap-3" id="button-group">
                    <div id="submit-container">
                        <button type="submit" class="submit-rating" id="submit-btn">
                            <span>Berikan Reaksi</span>
                            <div class="spinner"></div>
                        </button>
                    </div>

                    <div id="close-container" class="d-none">
                        <button type="button" class="btn btn-secondary" id="close-btn" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('input[name="reaction"]').change(function() {
                $('#submit-btn').prop('disabled', false);
            });

            $('#survey-form').submit(function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = $('#submit-btn');

                submitBtn.addClass('loading');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        $('#form-content').hide();
                        $('#thankyou-message').show();
                        $('#submit-container').addClass('d-none');
                        $('#close-container').removeClass('d-none');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    },
                    complete: function() {
                        submitBtn.removeClass('loading');
                    }
                });
            });
        });
    </script>
@endsection
