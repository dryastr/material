@extends('area._base')
@push('head')
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Profil</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset(Auth::user()->img) }}" class="rounded" style="width: 100px" alt="">
                    </div>
                    <div class="d-block d-md-flex justify-content-between mt-4">
                        <p class="m-0 mr-3">Username</p>
                        <p class="m-0 text-muted">{{ Auth::User()->username }}</p>
                    </div>
                    <div class="d-block d-md-flex justify-content-between mt-4">
                        <p class="m-0 mr-3">Nama</p>
                        <p class="m-0 text-muted">{{ Auth::User()->nama }}</p>
                    </div>
                    <div class="d-block d-md-flex justify-content-between mt-4">
                        <p class="m-0 mr-3">Email</p>
                        <p class="m-0 text-muted">{{ Auth::User()->email ?? '-' }}</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-4 w-100" onclick="editData('{{ Auth::user() }}')">Edit Profil</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('modal')
    {{-- modal edit --}}
    <div class="modal fade" id="modal_edit" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Edit Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_edit">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama_edit">
                            <div id="error_nama_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" id="username_edit">
                            <div id="error_username_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="email_edit">
                            <div id="error_email_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="password" id="password_edit">
                            <span style="font-size: 10px" class="text-muted">*kosongkan bila tidak ingin mengganti password</span>
                            <div id="error_password_edit" class="invalid-feedback"></div>
                        </div>
                        <button type="submmit" id="btn_edit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
@endsection
@push('js')
    <script>
        function editData(data) {
            var decodedData = decodeURIComponent(data);
            var rowData = JSON.parse(decodedData);
            $("#nama_edit").val(rowData.nama);
            $("#username_edit").val(rowData.username);
            $("#email_edit").val(rowData.email);
            $("#modal_edit").modal("show");
        }

        $("#form_edit").submit(function(e) {
            $("#btn_edit").prop("disabled", true);

            $("#nama_edit").removeClass('is-invalid');
            $("#email_edit").removeClass('is-invalid');
            $("#username_edit").removeClass('is-invalid');
            $("#password_edit").removeClass('is-invalid');

            var formdata = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('profil/edit') }}",
                data: formdata,
                dataType: 'json',
                success: function(response) {
                    $("#btn_edit").prop("disabled", false);
                    if (response.status == "1") {
                        swal.fire({
                            icon: "success",
                            title: 'Berhasil',
                            text: response.msg,
                            showConfirmButton: true,
                            timer: 900
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 900);
                    } else {
                        swal.fire({
                            icon: "error",
                            title: 'Gagal !',
                            text: response.msg,
                            showConfirmButton: true,
                            timer: 900
                        });
                    }
                },
                error: function(response) {
                    $("#btn_edit").prop("disabled", false);
                    if (response.status == 422) {
                        let errorResponse = JSON.parse(response.responseText);

                        if (errorResponse.errors && errorResponse.errors.nama) {
                            let errors = errorResponse.errors;
                            $("#nama_edit").addClass('is-invalid');
                            $("#error_nama_edit").html(errors.nama[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.username) {
                            let errors = errorResponse.errors;
                            $("#username_edit").addClass('is-invalid');
                            $("#error_username_edit").html(errors.username[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.email) {
                            let errors = errorResponse.errors;
                            $("#email_edit").addClass('is-invalid');
                            $("#error_email_edit").html(errors.email[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.password) {
                            let errors = errorResponse.errors;
                            $("#password_edit").addClass('is-invalid');
                            $("#error_password_edit").html(errors.password[0]);
                        }
                    } else {
                        errorAjaxResponse(response);
                    }
                }
            });
            e.preventDefault();
        });
    </script>
@endpush
