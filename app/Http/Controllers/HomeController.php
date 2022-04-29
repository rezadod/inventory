<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role_id = Auth::user()->role_id;
        $jenis_inventory = DB::table('jenis_inventory')
                        ->get();

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->leftjoin('status_hapus', 'inventory.status_hapus', 'status_hapus.id')
                        ->select(
                            'inventory.*',
                            'status_hapus.deskripsi as is_hapus',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        );
                    if($role_id == 1){
                        $inventory = $inventory->where('status_hapus', 0);
                    }
                        $inventory = $inventory->get();
                        
        return view('home', compact('jenis_inventory', 'inventory'));
    }
    
    public function save_input_barang(Request $request)
    {
        $user_id = Auth::user()->id;
        $foto_barang = $request->file('fotoBarang');
        $bukti_tf = $request->file('buktiTransaksi');
        
        $namaFotoBarang = uniqid('foto_barang_');
        $eksetensiFotoBarang = $foto_barang->getClientOriginalExtension();
        $namaFotoBarangBaru = $namaFotoBarang. '.' .$eksetensiFotoBarang;
        $direktoriUploadBarangBaru = public_path().'/foto_barang';
        $foto_barang->move($direktoriUploadBarangBaru, $namaFotoBarangBaru);
        
        $namaBuktiTf = uniqid('bukti_tf_');
        $eksetensiBuktiTf = $bukti_tf->getClientOriginalExtension();
        $namaBuktiTfBaru = $namaBuktiTf. '.' .$eksetensiBuktiTf;
        $direktoriUploadBuktiTf = public_path().'/bukti_tf';
        $bukti_tf->move($direktoriUploadBuktiTf, $namaBuktiTfBaru);

        DB::table('inventory')->insert([
            'nama_barang'=>$request->namaBarang,
            'jumlah_barang'=>$request->jumlahBarang,
            'foto_barang'=>$namaFotoBarangBaru,
            'bukti_transaksi'=>$namaBuktiTfBaru,
            'harga_barang'=>$request->hargaBarang,
            'jenis_inventory'=>$request->jenisBarang,
            'user_id'=>$user_id,
        ]);

        return redirect()->back()->with('status', 'Inventory Berhasil Ditambahkan');
    }
    
    public function save_edit_barang(Request $request)
    {
        $user_id = Auth::user()->id;
        $foto_barang = $request->file('fotoBarang');
        $bukti_tf = $request->file('buktiTransaksi');
        
        if($foto_barang){
            $namaFotoBarang = uniqid('$foto_barang_');
            $eksetensiFotoBarang = $foto_barang->getClientOriginalExtension();
            $namaFotoBarangBaru = $namaFotoBarang. '.' .$eksetensiFotoBarang;
            $direktoriUploadBarangBaru = public_path().'/foto_barang';
            $foto_barang->move($direktoriUploadBarangBaru, $namaFotoBarangBaru);
        }else{
            $namaFotoBarangBaru = $request->edit_fotoBarangLama;
        }
        
        if($bukti_tf){
            $namaBuktiTf = uniqid('bukti_tf_');
            $eksetensiBuktiTf = $bukti_tf->getClientOriginalExtension();
            $namaBuktiTfBaru = $namaBuktiTf. '.' .$eksetensiBuktiTf;
            $direktoriUploadBuktiTf = public_path().'/bukti_tf';
            $bukti_tf->move($direktoriUploadBuktiTf, $namaBuktiTfBaru);
        }else{
            $namaBuktiTfBaru = $request->edit_buktiTransaksiLama;
        }

        DB::table('inventory')
        ->where('id', $request->id)
        ->update([
            'nama_barang'=>$request->namaBarang,
            'jumlah_barang'=>$request->jumlahBarang,
            'foto_barang'=>$namaFotoBarangBaru,
            'bukti_transaksi'=>$namaBuktiTfBaru,
            'harga_barang'=>$request->hargaBarang,
            'jenis_inventory'=>$request->jenisBarang,
            'keterangan_barang'=>$request->keteranganBarang
        ]);

        return redirect()->back()->with('edit', 'Inventory Berhasil Diedit');
    }
    
    public function hapus_inventory(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;

        DB::table('inventory')
        ->where('id', $id)
        ->update([
            'status_hapus' => '1'
        ]);
    }
    
    public function edit_inventory(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;

        $inventory = DB::table('inventory')
        ->where('id', $id)
        ->first();

        $jenis_inventory = DB::table('jenis_inventory')
        ->get();

        return view('widget.modal_edit', compact('inventory', 'jenis_inventory'));
    }
    
    public function detail_inventory(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->select(
                            'inventory.*',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        )
                        ->where('inventory.id', $id)
                        ->first();

        return view('widget.modal_detail', compact('inventory'));
    }
}
