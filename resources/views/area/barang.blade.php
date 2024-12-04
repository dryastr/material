@extends('area._base')
@push('head')
@endpush
@section('content')
    <div class="card ">
        <div class="card-header">
            <h4>Master Barang</h4>
            <div class="card-header-action">
                <button href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_add"><i class="fas fa-plus"></i> Tambah</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-1" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>foto</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($barang as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><img src="{{ asset($row->foto) }}" style="width:100px" alt=""></td>
                                <td>{{ $row->kode }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->stok }}</td>
                                <td>
                                    <a href="javascript:;" onclick="editData('{{ $row }}')" class="btn btn-icon btn-sm btn-warning mx-1"><i class="fas fa-edit" style="width: 16px"></i></a>
                                    <a href="javascript:;" onclick="deleteData('{{ $row->id }}')" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash" style="width: 16px"></i></a>
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
                    <h5 class="modal-title" id="formModal">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_add" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" class="form-control" name="kode" id="kode_add">
                            <div id="error_kode_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama_add">
                            <div id="error_nama_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok_add">
                            <div id="error_stok_add" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto_add" accept=".jpg, .jpeg, .png">
                            <div id="error_foto_add" class="invalid-feedback"></div>
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
                    <h5 class="modal-title" id="formModal">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_edit" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id_edit">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" class="form-control" name="kode" id="kode_edit">
                            <div id="error_kode_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama_edit">
                            <div id="error_nama_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok_edit">
                            <div id="error_stok_edit" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto_edit" accept=".jpg, .jpeg, .png">
                            <div id="error_foto_edit" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" id="btn_edit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
@endsection
@push('js')
    <script>
        $("#form_add").submit(function(e) {
            $("#btn_add").prop("disabled", true);

            $("#nama_add").removeClass('is-invalid');
            $("#kode_add").removeClass('is-invalid');
            $("#stok_add").removeClass('is-invalid');
            $("#foto_add").removeClass('is-invalid');
            var formdata = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('barang/tambah') }}",
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
                        if (errorResponse.errors && errorResponse.errors.kode) {
                            let errors = errorResponse.errors;
                            $("#kode_add").addClass('is-invalid');
                            $("#error_kode_add").html(errors.kode[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.stok) {
                            let errors = errorResponse.errors;
                            $("#stok_add").addClass('is-invalid');
                            $("#error_stok_add").html(errors.stok[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.foto) {
                            let errors = errorResponse.errors;
                            $("#foto_add").addClass('is-invalid');
                            $("#error_foto_add").html(errors.foto[0]);
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
            $("#kode_edit").val(rowData.kode);
            $("#stok_edit").val(rowData.stok);
            $("#modal_edit").modal("show");
        }

        $("#form_edit").submit(function(e) {
            $("#btn_edit").prop("disabled", true);

            $("#nama_edit").removeClass('is-invalid');
            $("#kode_edit").removeClass('is-invalid');
            $("#stok_edit").removeClass('is-invalid');
            $("#foto_edit").removeClass('is-invalid');
            var formdata = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('barang/edit') }}",
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
                        if (errorResponse.errors && errorResponse.errors.kode) {
                            let errors = errorResponse.errors;
                            $("#kode_edit").addClass('is-invalid');
                            $("#error_kode_edit").html(errors.kode[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.stok) {
                            let errors = errorResponse.errors;
                            $("#stok_edit").addClass('is-invalid');
                            $("#error_stok_edit").html(errors.stok[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.foto) {
                            let errors = errorResponse.errors;
                            $("#foto_edit").addClass('is-invalid');
                            $("#error_foto_edit").html(errors.foto[0]);
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
                        url: "{{ url('barang/hapus') }}",
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
