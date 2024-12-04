<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('files/img/namikulo.png') }}' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container ">
                <div class="row align-items-center" style="height: 100vh;">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-middle mb-4">
                                    {{-- <img src="{{ asset('files/img/namikulo.png') }}" alt="" class="mr-1 my-auto" style="width: 20px; height:20px"> --}}
                                    <h3 class="m-0 my-auto">PT Ciba Vision</h3>
                                </div>
                                <form id="form_login">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control" name="username"
                                            autofocus>
                                        <div id="error_username" class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label">Password</label>
                                        <input id="password" type="password" class="form-control" name="password">
                                        <div id="error_password" class="invalid-feedback"></div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                            <label class="custom-control-label" for="remember">Remember Me</label>
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/alert/package/dist/sweetalert2.all.js') }} "></script>
    <script>
        $("#form_login").submit(function(e) {
            $("#username").removeClass('is-invalid');
            $("#password").removeClass('is-invalid');
            const formdata = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('auth') }}",
                data: formdata,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "1") {
                        swal.fire({
                            icon: "success",
                            title: 'Success',
                            text: response.msg,
                            showConfirmButton: true,
                            timer: 900
                        });
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 900);
                    } else {
                        swal.fire({
                            icon: "error",
                            title: 'Login Gagal !',
                            text: response.msg,
                            showConfirmButton: true,
                            timer: 900
                        });
                    }
                },
                error: function(response) {
                    if (response.status == 422) {
                        let errorResponse = JSON.parse(response.responseText);

                        if (errorResponse.errors && errorResponse.errors.username) {
                            let errors = errorResponse.errors;
                            $("#username").addClass('is-invalid');
                            $("#error_username").html(errors.username[0]);
                        }

                        if (errorResponse.errors && errorResponse.errors.password) {
                            let errors = errorResponse.errors;
                            $("#password").addClass('is-invalid');
                            $("#error_password").html(errors.password[0]);
                        }
                    } else if (response.status == 500) {
                        Swal.fire({
                            title: 'Ops...',
                            text: 'Sepertinya terjadi kesalahan',
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    } else if (response.status == 500) {
                        swal.fire({
                            icon: "error",
                            title: 'Ops...',
                            text: 'Sepertinya terjadi kesalahan',
                            showConfirmButton: true,
                        });
                    } else if (response.status == 419) {
                        swal.fire({
                            icon: "error",
                            title: 'Ops...',
                            text: 'Halaman kadaluarsa, silahkan reload halaman',
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        swal.fire({
                            icon: "error",
                            title: 'Ops...',
                            text: 'Sepertinya terjadi kesalahan',
                            showConfirmButton: true,
                        });
                    }
                }
            });
            e.preventDefault();
        });
    </script>
    @if (session('error'))
        <script>
            swal.fire({
                icon: "error",
                title: 'Gagal !',
                text: "{{ session('error') }}",
                showConfirmButton: true,
                timer: 900
            });
        </script>
    @endif
</body>

</html>
