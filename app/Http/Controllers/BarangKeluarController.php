<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\barangkeluar; // Pastikan untuk mengimpor model Kategori
use App\Models\barangmasuk; // Pastikan untuk mengimpor model Kategori
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class BarangkeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rsetBarangkeluar = barangkeluar::all();
        return view('v_barangkeluar.index', compact('rsetBarangkeluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rsetBarang = Barang::all();
        return view('v_barangkeluar.create', compact('rsetBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_keluar' => 'required|date|after_or_equal:tgl_masuk',
            'qty_keluar' => 'nullable|integer',
            'barang_id' => 'required|exists:barang,id',
        ],[
            'tgl_keluar.after_or_equal' => 'Tanggal keluar harus setelah atau sama dengan tanggal masuk.',
        ]);
        
        $tgl_masuk = barangmasuk::where('barang_id', $request->barang_id)->value('tgl_masuk');
        $tgl_keluar = barangkeluar::where('barang_id', $request->barang_id)->value('tgl_keluar');

        // Jika tanggal keluar lebih awal dari tanggal masuk, tampilkan pesan kesalahan
        if ($request->$tgl_keluar < $tgl_masuk) {
            return redirect()->route('barangkeluar.create')->with(['Gagal' => 'Tanggal Keluar Tidak Boleh Lebih Awal Dari Tanggal Masuk']);
        }
        
        if ($validator->fails()) {
            return redirect()->route('barangkeluar.create')
                ->withErrors($validator)
                ->withInput();
        }

        // barangkeluar::create([
        //     'tgl_keluar' => $request->tgl_keluar,
        //     'qty_keluar' => $request->qty_keluar,
        //     'barang_id' => $request->barang_id,
        // ]);

        try {
            // Insert a new row into the barangkeluar table
            DB::table('barangkeluar')->insert([
                'barang_id' => $request->input('barang_id'),
                'qty_keluar' => $request->input('qty_keluar'),
                // other columns...
            ]);

            // Display a success message
            return redirect()->route('barangkeluar.index')->with('success', 'Item successfully removed from stock.');
        } catch (\Exception $e) {
            // Display an error message
            return redirect()->route('barangkeluar.create')->with('alert', 'Stock cannot be minus');
        }
    

        // return redirect()->route('barangkeluar.index')->with(['success' => 'Data Barang Berhasil Disimpan!']);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangkeluar = barangkeluar::find($id);

        return view('v_barangkeluar.show', compact('rsetBarangkeluar'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rsetBarangkeluar = barangkeluar::find($id);
        $rsetBarang = Barang::all(); // Anda mungkin perlu menyesuaikan ini sesuai dengan model dan tabel kategori Anda
        return view('v_barangkeluar.edit', compact('rsetBarangkeluar', 'rsetBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_keluar' => 'required|date',
            'qty_keluar' => 'nullable|integer',
            'barang_id' => 'required|exists:barang,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('barangkeluar.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $rsetBarangkeluar = barangkeluar::find($id);

        $rsetBarangkeluar->update([
            'tgl_keluar' => $request->tgl_keluar,
            'qty_keluar' => $request->qty_keluar,
            'barang_id' => $request->barang_id,
        ]);

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Barang Berhasil Disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barangkeluar = barangkeluar::find($id);
        Storage::delete('public/foto/' . $barangkeluar->foto);
        $barangkeluar->delete();
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Barang Berhasil Dihapus!']);
    }
}
