@extends('area._base')
@push('head')
@endpush
@section('content')
    <div class="card ">
        <div class="card-header">
            <h4>Riwayat Pemesanan</h4>
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
                                <td>
                                    @php
                                        if (Auth::user()->role == 'Supervisor') {
                                            echo $row->status_spv;
                                        } elseif (Auth::user()->role == 'Admin') {
                                            echo $row->status_admin;
                                        } else {
                                            if ($row->status_spv == 'Reject') {
                                                echo 'Reject by SPV';
                                            } elseif ($row->status_admin == 'Reject') {
                                                echo 'Reject by Admin';
                                            } else {
                                                echo $row->status_admin;
                                            }
                                        }
                                    @endphp
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
@endsection
@push('js')
@endpush
