<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator; //import validasi
use App\Models\Pendaftaran; 


class PendaftaranController extends Controller
{
    public function index() //method tampil semua data product (read)
    {
        $pendaftaran = Pendaftaran::all(); //mengambil semua data course

        if(count($pendaftaran) > 0)  {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pendaftaran
            ], 200); //return data semua course dalam bentuk JSON
        }
        
        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //return message data course kosong
    }

    //method tampil 1 data course(search)
    public function show($id)
    {
        $pendaftaran = Pendaftaran::find($id);

        if(!is_null($pendaftaran))   {
            return response([
                'message' => 'Retrieve Pendaftaran Success',
                'data' => $pendaftaran
            ], 200); //return semua data course dalam bentuk json
        }

        return response([
            'message' => 'Pendaftaran Not Found',
            'data' => null
        ], 400); //return message data course kosong
    }

    public function store(Request $request)
    {
        $storeData = $request->all(); //ambil semua input dari api client
        $validate = Validator::make($storeData, [
            'namaPendaftar' => 'required|regex:/^[\pL\s\-]+$/u',
            'tanggalLahirPendaftar' => 'required',
            'nomorHPPendaftar' => 'required|numeric|digits_between:10,13|starts_with:08',
            'jenisKelaminPendaftar' => 'required',
            'keluhanPendaftar' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        $pendaftaran = Pendaftaran::create($storeData);
        return response([
            'message' => 'Add Pendaftaran Success',
            'data' => $pendaftaran
        ], 200); //return message data course baru dalam bentuk json
    }

    //method hapus 1 data product (delete)
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::find($id); //mencari data product dari id

        if(is_null($pendaftaran))  {
            return response([
                'message' => 'Pendaftaran Not Found',
                'data' => null
            ], 404);
        } //return message data course tidak ditemukan

        if($pendaftaran->delete())  {
            return response([
                'message' => 'Delete Pendaftaran Success',
                'data' => $pendaftaran
            ], 200);
        } //return message saat berhasil hapus data course

        return response([
            'message' => 'Delete Pendaftaran Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::find($id);
        if(is_null($pendaftaran))  {
            return response([
                'message' => 'Pendaftaran Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPendaftar' => ['max:60', 'required', Rule::unique('pendaftarans')->ignore($pendaftaran)],
            'tanggalLahirPendaftar' => 'required',
            'nomorHPPendaftar' => 'required|numeric|digits_between:10,13|starts_with:08',
            'jenisKelaminPendaftar' => 'required',
            'keluhanPendaftar' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
        $pendaftaran->namaPendaftar = $updateData['namaPendaftar'];
        $pendaftaran->tanggalLahirPendaftar = $updateData['tanggalLahirPendaftar'];
        $pendaftaran->nomorHPPendaftar = $updateData['nomorHPPendaftar'];
        $pendaftaran->jenisKelaminPendaftar = $updateData['jenisKelaminPendaftar'];
        $pendaftaran->keluhanPendaftar = $updateData['keluhanPendaftar'];

        if($pendaftaran->save())  {
            return response([
                'message' => 'Update Pendaftaran Success',
                'data' => $pendaftaran
            ], 200);
        }
        return response([
            'message' => 'Update Pendaftaran Failed',
            'data' => null,
        ], 400);
    }
}
