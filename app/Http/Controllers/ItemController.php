<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    // 1. Fungsi Menampilkan Semua Barang
    public function index()
    {
        $items = [
            ['id' => 1, 'nama_barang' => 'Laptop ASUS ROG', 'stok' => 10, 'harga' => 15000000],
            ['id' => 2, 'nama_barang' => 'Mouse Gaming Logitech', 'stok' => 25, 'harga' => 450000]
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data barang',
            'data' => $items
        ], 200);
    }

    // 2. Fungsi Menambah Barang Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'stok'        => 'required|integer',
            'harga'       => 'required|integer',
        ]);

        $dataBaru = [
            'nama_barang' => $request->nama_barang,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data barang baru berhasil ditambahkan! (Simulasi)',
            'data_terinput' => $dataBaru
        ], 201);
    }

    // 3. Fungsi Menampilkan Detail Satu Barang (Langkah 3)
    public function show($id)
    {
        $items = [
            1 => ['id' => 1, 'nama_barang' => 'Laptop ASUS ROG', 'stok' => 10, 'harga' => 15000000],
            2 => ['id' => 2, 'nama_barang' => 'Mouse Gaming Logitech', 'stok' => 25, 'harga' => 450000]
        ];

        if (!array_key_exists($id, $items)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data barang tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil detail barang',
            'data' => $items[$id]
        ], 200);
    }

    // 4. Fungsi Mengubah Data Barang (Langkah 4)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'stok'        => 'required|integer',
            'harga'       => 'required|integer',
        ]);

        $dataUpdate = [
            'id' => (int)$id,
            'nama_barang' => $request->nama_barang,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data barang dengan ID ' . $id . ' berhasil diperbarui! (Simulasi)',
            'data_terupdate' => $dataUpdate
        ], 200);
    }
} // <-- Kurung kurawal penutup class HANYA BOLEH ADA SATU di paling bawah file!