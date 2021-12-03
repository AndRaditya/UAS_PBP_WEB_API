<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator; //import validasi
use App\Models\TransaksiObat; 

class TransaksiObatController extends Controller
{
    public function index() //method tampil semua data product (read)
    {
        $transaksiObat = TransaksiObat::all(); //mengambil semua data course

        if(count($transaksiObat) > 0)  {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $transaksiObat
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
        $transaksiObat = TransaksiObat::find($id);

        if(!is_null($transaksiObat))   {
            return response([
                'message' => 'Retrieve Transaksi Obat Success',
                'data' => $transaksiObat
            ], 200); //return semua data course dalam bentuk json
        }

        return response([
            'message' => 'Transaksi Obat Not Found',
            'data' => null
        ], 400); //return message data course kosong
    }

    public function store(Request $request)
    {
        $storeData = $request->all(); //ambil semua input dari api client
        $validate = Validator::make($storeData, [
            'namaPembeli' => 'required|regex:/^[\pL\s\-]+$/u',
            'nomorHpPembeli' => 'required|numeric',
            'alamatPembeli' => 'required',
            'umurPembeli' => 'required|numeric',
            'jumlahBeli' => 'required|numeric',
            'idObat' => 'required',
            'totalBayarObat' => 'required|numeric'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input

        $transaksiObat = TransaksiObat::create($storeData);
        return response([
            'message' => 'Add Transaksi Obat Success',
            'data' => $transaksiObat
        ], 200); //return message data course baru dalam bentuk json
    }

    //method hapus 1 data product (delete)
    public function destroy($id)
    {
        $transaksiObat = TransaksiObat::find($id); //mencari data product dari id

        if(is_null($transaksiObat))  {
            return response([
                'message' => 'Transaksi Obat Not Found',
                'data' => null
            ], 404);
        } //return message data course tidak ditemukan

        if($transaksiObat->delete())  {
            return response([
                'message' => 'Delete Transaksi Obat Success',
                'data' => $transaksiObat
            ], 200);
        } //return message saat berhasil hapus data course

        return response([
            'message' => 'Delete Transaksi Obat Failed',
            'data' => null,
        ], 400);
    }

    
    public function update(Request $request, $id)
    {
        $transaksiObat = TransaksiObat::find($id);
        if(is_null($transaksiObat))  {
            return response([
                'message' => 'Transaksi Obat Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPembeli' => ['max:60', 'required', Rule::unique('transaksi_obats')->ignore($transaksiObat)],
            'nomorHpPembeli' => 'required|numeric',
            'alamatPembeli' => 'required',
            'umurPembeli' => 'required|numeric',
            'jumlahBeli' => 'required|numeric',
            'idObat' => 'required',
            'totalBayarObat' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
        $transaksiObat->namaPembeli = $updateData['namaPembeli'];
        $transaksiObat->nomorHpPembeli = $updateData['nomorHpPembeli'];
        $transaksiObat->alamatPembeli = $updateData['alamatPembeli'];
        $transaksiObat->umurPembeli = $updateData['umurPembeli'];
        $transaksiObat->jumlahBeli = $updateData['jumlahBeli'];
        $transaksiObat->idObat = $updateData['idObat'];
        $transaksiObat->totalBayarObat = $updateData['totalBayarObat'];

        if($transaksiObat->save())  {
            return response([
                'message' => 'Update Transaksi Obat Success',
                'data' => $transaksiObat
            ], 200);
        }
        return response([
            'message' => 'Update Transaksi Obat Failed',
            'data' => null,
        ], 400);
    }
}
