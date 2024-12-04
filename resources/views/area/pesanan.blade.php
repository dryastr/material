@extends('area._base')
@push('head')
@endpush
@section('content')
    <div class="card ">
        <div class="card-header">
            <h4>Pesanan Masuk</h4>
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
                            <th>Kode Pesanan</th>
                            <th>Departemen</th>
                            <th>Nama Pemesan</th>
                            <th>Request Item</th>
                            <th>Foto</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($pesanan as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->kode }}</td>
                                <td>{{ $row->pemesan->departement }}</td>
                                <td>{{ $row->pemesan->nama }}</td>
                                <td>{{ $row->barang->nama }}</td>
                                <td><img src="{{ asset($row->barang->foto) }}" style="width:100px" alt=""></td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ Auth::user()->role == 'Supervisor' ? $row->status_spv : $row->status_admin }}</td>
                                <td>
                                    <a href="javascript:;" onclick="editData('{{ $row->id }}','{{ Auth::user()->role == 'Supervisor' ? $row->status_spv : $row->status_admin }}')" class="btn btn-icon btn-sm btn-warning mx-1"><i class="fas fa-edit" style="width: 16px"></i></a>
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
    {{-- modal edit --}}
    <div class="modal fade" id="modal_edit" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Request Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_edit">
                        <input type="hidden" name="id" id="id_edit">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_pending" value="Pending">
                                        <label class="form-check-label" for="status_pending">
                                            Pending
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_done" value="Done">
                                        <label class="form-check-label" for="status_done">
                                            Done
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_reject" value="Reject">
                                        <label class="form-check-label" for="status_reject">
                                            Reject
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <textarea name="penolakan" id="penolakan_edit" placeholder="Alasan penolakan" rows="10" class="form-control" style="height: auto;
            min-height: 10em;"></textarea>
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->role == 'Supervisor')
                            <span class="text-muted">*Jika menyetujui pesanan, maka pesanan akan dikirimkan kepada admin</span>
                        @endif
                        <button type="submit" id="btn_edit" class="btn btn-primary m-t-15 waves-effect">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
@endsection
@push('js')
    <script>
        function editData(id, status) {
            $("#id_edit").val(id);
            if (status == 'Pending') {
                $('#status_pending').prop('checked', true);
            }
            if (status == 'Done') {
                $('#status_done').prop('checked', true);
            }
            if (status == 'Reject') {
                $('#status_reject').prop('checked', true);
            }

            if (status == 'Reject') {
                $('#penolakan_edit').show();
            } else {
                $('#penolakan_edit').hide();
            }
            $("#modal_edit").modal("show");
        }

        $('input[name="status"]').on('change', function() {
            if ($('#status_reject').is(':checked')) {
                $('#penolakan_edit').show();
            } else {
                $('#penolakan_edit').hide();
            }
        });

        $("#form_edit").submit(function(e) {
            $("#btn_edit").prop("disabled", true);
            var formdata = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('pesanan/edit') }}",
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
                    errorAjaxResponse(response);
                }
            });
            e.preventDefault();
        });
    </script>
@endpush
