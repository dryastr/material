@extends('area._base')
@push('head')
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card ">
                <div class="card-header">
                    <h4>Permintaan Pesanan</h4>
                </div>
                <div class="card-body">
                    <form id="form_add">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Request By</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->nama }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Request Qty</label>
                                    <input type="number" class="form-control" name="qty" id="qty_add">
                                    <div id="error_qty_add" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Requested Item</label>
                                    <select id="id_barang_add" name="id_barang" class="form-control">
                                        <option></option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->id }}" data-foto="{{ asset($item->foto) }}">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="error_id_barang_add" class="invalid-feedback"></div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Note (Optional)</label>
                                    <textarea name="note" id="note_add" rows="10" class="form-control"
                                        style="height: auto;
            min-height: 10em;"></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <img id="barang-image" src="" alt="Preview Barang" class="img-thumbnail"
                                        style="display: none; width: 150px; height: 150px;">
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="btn_add" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#id_barang_add').select2({
                width: '100%',
                placeholder: 'Pilih'
            });
        })

        $('#id_barang_add').change(function() {
            var selectedOption = $(this).find('option:selected');
            var imageUrl = selectedOption.data('foto');

            if (imageUrl) {
                $('#barang-image').attr('src', imageUrl).show();
            } else {
                $('#barang-image').hide();
            }
        });

        $("#form_add").submit(function(e) {
            $("#btn_add").prop("disabled", true);

            $("#qty_add").removeClass('is-invalid');
            $("#id_barang_add").removeClass('is-invalid');
            var formdata = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                method: 'post',
                url: "{{ url('pesanan/tambah') }}",
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

                        if (errorResponse.errors && errorResponse.errors.qty) {
                            let errors = errorResponse.errors;
                            $("#qty_add").addClass('is-invalid');
                            $("#error_qty_add").html(errors.qty[0]);
                        }
                        if (errorResponse.errors && errorResponse.errors.id_barang) {
                            let errors = errorResponse.errors;
                            $("#id_barang_add").addClass('is-invalid');
                            $("#error_id_barang_add").html(errors.id_barang[0]);
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
