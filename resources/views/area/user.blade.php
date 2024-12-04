@extends('area._base')
@push('head')
@endpush
@section('content')
    <div class="card ">
        <div class="card-header">
            <h4>Data User</h4>
            <div class="card-header-action">
                <button href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_add"><i
                        class="fas fa-plus"></i> Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-1" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Departemen</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($user as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->departement }}</td>
                                <td>{{ $row->role }}</td>
                                <td>
                                    <a href="javascript:;" onclick="editData('{{ $row }}')"
                                        class="btn btn-icon btn-sm btn-warning mx-1"><i class="fas fa-edit"
                                            style="width: 16px"></i></a>
                                    <a href="javascript:;" onclick="deleteData('{{ $row->id }}')"
                                        class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash"
                                            style="width: 16px"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    {{-- modal add --}}
    <div class="modal fade" id="modal_add" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_add">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama_add">
                            <div id="error_nama_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" id="username_add">
                            <div id="error_username_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="email_add">
                            <div id="error_email_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Departement (OPsional)</label>
                            <input type="text" class="form-control" name="departement" id="departement_add">
                            <div id="error_departement_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="role_add" class="form-control">
                                <option value="">-Pilih-</option>
                                <option value="Admin">Admin</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Staff">Staff</option>
                            </select>
                            <div id="error_role_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="password" id="password_add">
                            <div id="error_password_add" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" id="btn_add" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal add --}}
    {{-- modal edit --}}
    <div class="modal fade" id="modal_edit" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_edit">
                        <input type="hidden" name="id" id="id_edit">
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
                            <label>Departement (Opsional)</label>
                            <input type="text" class="form-control" name="departement" id="departement_edit">
                            <div id="error_departement_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="role_edit" class="form-control">
                                <option value="">-Pilih-</option>
                                <option value="Admin">Admin</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Staff">Staff</option>
                            </select>
                            <div id="error_role_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="password" id="password_edit">
                            <div id="error_password_edit" class="invalid-feedback"></div>
                            <span class="text-muted">*Kosongkan bila tidak ingin mengganti password</span>
                        </div>
                        <button type="submit" id="btn_edit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal add --}}
@endsection
@push('js')
    <script>
        $("#form_add").submit(function(e) {
            $("#btn_add").prop("disabled", true);

            $("#nama_add").removeClass('is-invalid');
            $("#username_add").removeClass('is-invalid');
            $("#email_add").removeClass('is-invalid');
            $("#role_add").removeClass('is-invalid');
            $("#password_add").removeClass('is-invalid');
            $("#departement_add").removeClass('is-invalid');
            var formdata = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('user/tambah') }}",
                data: formdata,
                dataType: 'json',
                success: function(response) {
                    $("#btn_add").prop("disabled", false);
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
                    $("#btn_add").prop("disabled", false);
                    if (response.status == 422) {
                        let errorResponse = JSON.parse(response.responseText);

                        if (errorResponse.errors && errorResponse.errors.nama) {
                            let errors = errorResponse.errors;
                            $("#nama_add").addClass('is-invalid');
                            $("#error_nama_add").html(errors.nama[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.username) {
                            let errors = errorResponse.errors;
                            $("#username_add").addClass('is-invalid');
                            $("#error_username_add").html(errors.username[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.email) {
                            let errors = errorResponse.errors;
                            $("#email_add").addClass('is-invalid');
                            $("#error_email_add").html(errors.email[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.departement) {
                            let errors = errorResponse.errors;
                            $("#departement_add").addClass('is-invalid');
                            $("#error_departement_add").html(errors.departement[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.role) {
                            let errors = errorResponse.errors;
                            $("#role_add").addClass('is-invalid');
                            $("#error_role_add").html(errors.role[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.password) {
                            let errors = errorResponse.errors;
                            $("#password_add").addClass('is-invalid');
                            $("#error_password_add").html(errors.password[0]);
                        }

                    } else {
                        errorAjaxResponse(response);
                    }
                }
            });
            e.preventDefault();
        });

        function editData(data) {
            var decodedData = decodeURIComponent(data);
            var rowData = JSON.parse(decodedData);
            $("#id_edit").val(rowData.id);
            $("#nama_edit").val(rowData.nama);
            $("#username_edit").val(rowData.username);
            $("#role_edit").val(rowData.role).change();
            $("#email_edit").val(rowData.email);
            $("#departement_edit").val(rowData.departement);
            $("#modal_edit").modal("show");
        }

        $("#form_edit").submit(function(e) {
            $("#btn_edit").prop("disabled", true);

            $("#nama_edit").removeClass('is-invalid');
            $("#username_edit").removeClass('is-invalid');
            $("#email_edit").removeClass('is-invalid');
            $("#departement_edit").removeClass('is-invalid');
            $("#role_edit").removeClass('is-invalid');
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
                url: "{{ url('user/edit') }}",
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
                        if (errorResponse.errors && errorResponse.errors.departement) {
                            let errors = errorResponse.errors;
                            $("#departement_edit").addClass('is-invalid');
                            $("#error_departement_edit").html(errors.departement[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.role) {
                            let errors = errorResponse.errors;
                            $("#role_edit").addClass('is-invalid');
                            $("#error_role_edit").html(errors.role[0]);
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

        function deleteData(id) {
            swal.fire({
                title: 'Apakah anda yakin??',
                text: "Anda tidak dapat mengembalikan ini !!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonClass: 'btn btn-danger mr-3',
                cancelButtonClass: 'btn btn-secondary',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "{{ url('user/hapus') }}",
                        data: 'id=' + id,
                        success: function(response) {
                            if (response.status == "1") {
                                swal.fire({
                                    icon: "success",
                                    title: 'Berhasil',
                                    text: response.msg,
                                    showConfirmButton: true,
                                    timer: 900
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.close();
                                        location.reload();
                                    }
                                });
                                setTimeout(function() {
                                    Swal.close();
                                    location.reload();
                                }, 900);
                            } else {
                                swal.fire("Error!", response.msg, "error");
                            }
                        },
                        error: function(response) {
                            errorAjaxResponse(response);
                        }
                    });
                }
            });
        }
    </script>
@endpush
