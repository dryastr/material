<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pesanan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function pesanan()
    {
        $data['title'] = 'Pesanan Masuk';
        $data['page'] = 'pesanan';

        if (Auth::user()->role == 'Supervisor') {
            $data['pesanan'] = Pesanan::with(['barang', 'pemesan'])->where('status_spv', 'Pending')->latest()->get();
        }
        if (Auth::user()->role == 'Admin') {
            $data['pesanan'] = Pesanan::with(['barang', 'pemesan'])->where('status_spv', 'Done')->where('status_admin', 'Pending')->latest()->get();
        }

        return view('area.pesanan', $data);
    }

    public function permintaan()
    {
        $data['title'] = 'Permintaan Pesanan';
        $data['page'] = 'permintaan';


        $data['barang'] = Barang::latest()->get();
        return view('area.permintaan', $data);
    }

    public function tambah(Request $request)
    {
        request()->validate([
            'qty' => 'required',
            'id_barang' => 'required|exists:barang,id',
        ]);

        $code_search = Pesanan::count();
        $code = 'P' . sprintf("%08d", ($code_search + 1));

        $data = $request->all();
        $data['kode'] = $code;
        $data['id_pemesan'] = Auth::user()->id;
        $data['status_spv'] = "Pending";
        $data['status_admin'] = "Pending";

        try {
            Pesanan::create($data);

            $response['status'] = '1';
            $response['msg'] = 'Berhasil menambahkan data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal menambahkan data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function edit(Request $request)
    {
        request()->validate([
            'status' => 'required',
        ]);

        if (Auth::user()->role == 'Supervisor') {
            $data['status_spv'] = $request->status;
            $data['penolakan_spv'] = $request->penolakan;
        } else {
            $data['status_admin'] = $request->status;
            $data['penolakan_admin'] = $request->penolakan;
        }

        try {
            Pesanan::where('id', $request->id)->update($data);

            $response['status'] = '1';
            $response['msg'] = 'Berhasil perbarui data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal perbarui data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function riwayat()
    {
        $data['title'] = 'Riwayat Pesanan';
        $data['page'] = 'riwayat';


        $pesanan = Pesanan::with(['barang', 'pemesan']);
        if (Auth::user()->role == 'Staff') {
            $pesanan = $pesanan->where('id_pemesan', Auth::user()->id);
        }
        if (Auth::user()->role == 'Admin') {
            $pesanan = $pesanan->where('status_spv', 'Done');
        }

        $data['pesanan'] = $pesanan->latest()->get();
        return view('area.riwayat', $data);
    }
}
