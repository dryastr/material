<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Exception;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data['title'] = 'Master Barang';
        $data['page'] = 'barang';
        $data['barang'] = Barang::latest()->get();
        return view('area.barang', $data);
    }

    public function tambah(Request $request)
    {
        request()->validate([
            'kode' => 'required|unique:barang,kode',
            'nama' => 'required',
            'stok' => 'required|numeric',
            'foto' => 'required|image|mimes:png,jpg'
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $file_name = 'img_' . date('YmdHis') . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            try {
                $file->storeAs('barang', $file_name, 'public');
                $data['foto'] = 'storage/barang/' . $file_name;
            } catch (\Exception $e) {
                $result['status'] = '0';
                $result['msg'] = 'Gagal mengupload foto';
                return response()->json($result);
            }
        }

        try {
            Barang::create($data);

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
            'kode' => 'required|unique:barang,kode,' . $request->id . ',id',
            'nama' => 'required',
            'stok' => 'required|numeric',
            'foto' => 'image|mimes:png,jpg'
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $file_name = 'img_' . date('YmdHis') . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            try {
                $file->storeAs('barang', $file_name, 'public');
                $data['foto'] = 'storage/barang/' . $file_name;
            } catch (\Exception $e) {
                $result['status'] = '0';
                $result['msg'] = 'Gagal mengupload foto';
                return response()->json($result);
            }
        }

        try {
            Barang::where('id', $request->id)->update($data);

            $response['status'] = '1';
            $response['msg'] = 'Berhasil perbarui data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal perbarui data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }

    public function hapus(Request $request)
    {
        try {
            Barang::where('id', $request->id)->delete();

            $response['status'] = '1';
            $response['msg'] = 'Berhasil menghapus data';
        } catch (Exception $e) {

            $response['status'] = '0';
            $response['msg'] = "Gagal menghapus data!!";
            $response['error'] = $e->getMessage();
        }

        return response()->json($response);
    }
}
