<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Validation\ValidationException;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(Barang::all());
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|unique:barangs,kode|max:255',
                'stok' => 'required|integer|min:0',
                'harga' => 'required|numeric|min:0', // Validasi untuk harga
                'kategori' => 'nullable|string|max:255', // Validasi untuk kategori
                'deskripsi' => 'nullable|string', // Validasi untuk deskripsi
                'gambar' => 'nullable|string', // URL atau path lokal
            ]);

            $barang = Barang::create($validatedData);
            return response()->json($barang, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show(string $id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }
        return response()->json($barang);
    }

    public function update(Request $request, string $id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }

        try {
            $validatedData = $request->validate([
                'nama' => 'sometimes|required|string|max:255',
                'kode' => 'sometimes|required|string|unique:barangs,kode,' . $id . '|max:255',
                'stok' => 'sometimes|required|integer|min:0',
                'harga' => 'sometimes|required|numeric|min:0',
                'kategori' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|string',
            ]);

            $barang->update($validatedData);
            return response()->json($barang);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(string $id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }

        $barang->delete();
        return response()->json(['message' => 'Barang deleted successfully'], 204);
    }
}

