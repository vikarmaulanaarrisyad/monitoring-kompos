@extends('layouts.guest')

@section('title', 'Login Page')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('login') }}" class="h1"><b>{{ $setting->nama_aplikasi ?? config('app.name') }}</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    {{ $setting->deskripsi_aplikasi ?? '' }}
                </p>
                <form id="loginForm" action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Username</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" autocomplete="off" onfocus=this.value=''>

                        @error('email')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror password"
                            id="password" name="password" onfocus=this.value='' autocomplete="off">

                        @error('password')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group d-flex justify-content-between align-items-center mb-3">
                        <div class="custom-control custom-checkbox" id="showPassword">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label for="customCheck1" class="custom-control-label" id="showPassword">Show
                                Password</label>
                        </div>
                    </div>

                    <div>
                        <button type="button" onclick="login()" id="loginButton"
                            class="btn btn-sm btn-primary btn-login mb-2 btn-block">
                            <i class="fas fa-sign-in-alt"></i> <span id="buttonText">Masuk</span>
                            <span id="loadingSpinner" style="display:none;"><i class="fas fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Menangani keypress event
        $(document).on('keypress', function(e) {
            if (e.which == 13) {
                login();
            }
        });

        // Fungsi untuk login
        function login() {
            let email = $('#email').val();
            let password = $('.password').val();

            if (!email) {
                toastr.info('Email wajib diisi');
                return;
            }

            if (!password) {
                toastr.info('Password wajib diisi');
                return;
            }

            // Disable the button to prevent multiple clicks during the Ajax request
            const loginButton = $('#loginButton');
            const buttonText = $('#buttonText');
            const loadingSpinner = $('#loadingSpinner');

            loginButton.attr('disabled', true);
            buttonText.hide();
            loadingSpinner.show();

            $.ajax({
                type: 'POST',
                url: '{{ route('login') }}',
                data: $('#loginForm').serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login berhasil',
                        text: 'Selamat anda berhasil login ke dalam sistem kami',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    });
                },
                error: function(errors) {
                    // Handle the error response
                    loopErrors(errors.responseJSON.errors);
                    toastr.error(errors.responseJSON.message);
                },
                complete: function() {
                    // Re-enable the button and hide the loading indicator
                    loginButton.attr('disabled', false);
                    buttonText.show();
                    loadingSpinner.hide();
                }
            });
        }
    </script>
@endpush
