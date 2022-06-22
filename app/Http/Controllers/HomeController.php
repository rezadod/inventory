<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Prophecy\Call\Call;

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
        $status_barang = DB::table('status_barang')
                        ->where('id', '!=', 0)
                        ->get();

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->leftjoin('status_barang', 'inventory.status_barang', 'status_barang.id')
                        ->select(
                            'inventory.*',
                            'status_barang.deskripsi as is_hapus',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        );
                        $inventory = $inventory->where('status_barang', 0);
                        $inventory = $inventory->get();
                        
        return view('home', compact('jenis_inventory', 'inventory', 'status_barang'));
    }

    public function tampi_barang(Request $request)
    {
        // dd($request);
        $tanggal_1 = $request->tanggal_1;
        $tanggal_2 = $request->tanggal_2;
        $role_id = Auth::user()->role_id;
        $jenis_inventory = $request->jenis_inventory;

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->leftjoin('status_barang', 'inventory.status_barang', 'status_barang.id')
                        ->select(
                            'inventory.*',
                            'status_barang.deskripsi as is_hapus',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        );
                        $inventory = $inventory->where('status_barang', 0);
                        if(!empty($jenis_inventory)){
                            $inventory = $inventory->where('inventory.jenis_inventory', $jenis_inventory);
                        }
                        if(!empty($tanggal_1)){
                            $inventory = $inventory->whereDate('inventory.tanggal_barang_ditambahkan', '>=', $tanggal_1);
                            $inventory = $inventory->whereDate('inventory.tanggal_barang_ditambahkan', '<=', $tanggal_2);
                        }
                        $inventory = $inventory->get();
                        
        return view('tampil_barang', compact('jenis_inventory', 'inventory'));
    }
    
    public function save_input_barang(Request $request)
    {
        $date_now = Carbon::now('Asia/jakarta')->format('Y-m-d H:i:s');
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
            'jumlah_barang_masuk'=>$request->jumlahBarang,
            'tanggal_barang_ditambahkan'=>$date_now,
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
        // dd($request);
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
            'jumlah_barang_diedit'=>$request->jumlahBarang,
            'foto_barang'=>$namaFotoBarangBaru,
            'bukti_transaksi'=>$namaBuktiTfBaru,
            'harga_barang'=>$request->hargaBarang,
            'jenis_inventory'=>$request->jenisBarang,
            'user_id' => $user_id,
            'keterangan_barang'=>$request->keteranganBarang
        ]);

        return redirect()->back()->with('edit', 'Inventory Berhasil Diedit');
    }
    
    public function hapus_inventory(Request $request)
    {
        // dd($request);
        $date_now = Carbon::now('Asia/Jakarta');
        $user_id = Auth::user()->id;
        $id = $request->id;
        $keterangan = $request->keterangan;
        $status_barang = $request->status_barang;
        $jml = DB::table('inventory')->select('jumlah_barang_masuk as jml')->where('id', $id)->first();
        DB::table('inventory')
        ->where('id', $id)
        ->update([
            'tanggal_barang_keluar' => $date_now,
            'jumlah_barang_keluar' => $jml->jml,
            'keterangan_barang' => $keterangan,
            'status_barang' => $status_barang
        ]);

        return redirect()->back()->with('hapus', 'Data Berhasil Dihapus!!');
    }
    
    public function edit_inventory(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;

        $inventory = DB::table('inventory')
        ->leftJoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
        ->select('inventory.*','jenis_inventory.deskripsi')
        ->where('inventory.id', $id)
        ->first();

        $jenis_inventory = DB::table('jenis_inventory')
        ->get();

        return view('widget.modal_edit', compact('inventory', 'jenis_inventory'));
    }
    public function hapus_data_inventory(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;

        $inventory = DB::table('inventory')
        ->leftJoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
        ->select('inventory.*','jenis_inventory.deskripsi')
        ->where('inventory.id', $id)
        ->first();

        $jenis_inventory = DB::table('jenis_inventory')
        ->get();
        $status_barang = DB::table('status_barang')
        ->where('id', '!=', 0)
        ->get();

        return view('widget.modal_hapus', compact('inventory', 'jenis_inventory', 'status_barang'));
    }
    
    public function detail_inventory(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->leftJoin('users', 'inventory.user_id', 'users.id')
                        ->select(
                            'inventory.*',
                            'users.name',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        )
                        ->where('inventory.id', $id)
                        ->first();

        return view('widget.modal_detail', compact('inventory'));
    }

    public function cek_produk(Request $request)
    {
        $nama_barang = $request->nama_barang;

        $data_cek = DB::table('inventory')
                    ->select('*')
                    ->where('nama_barang', $nama_barang)
                    ->get();

        // dd($data_cek);
        return response()->json($data_cek, 200);
    }

    public function cek_qty(Request $request)
    {
        $nama_barang = $request->nama_barang;

        $data_cek = DB::table('inventory')
                    ->select('*')
                    ->where('id', $nama_barang)
                    ->get();

        // dd($data_cek);
        return response()->json($data_cek, 200);
    }

    // BARANG KELUAR
    public function report_barang_keluar()
    {
        $role_id = Auth::user()->role_id;
        $jenis_inventory = DB::table('jenis_inventory')
                        ->get();

        $status_barang = DB::table('status_barang')
                        ->where('id', '!=', 0)
                        ->get();

        $daftar_barang = DB::table('inventory')
                        ->select(
                            'id',
                            'nama_barang',
                            DB::raw('(inventory.jumlah_barang_masuk) - (inventory.jumlah_barang_keluar) as jml_sisa')
                        )
                        ->where('status_barang', '>=', 0)
                        ->having('jml_sisa', '>', 0)
                        ->get();

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->leftjoin('status_barang', 'inventory.status_barang', 'status_barang.id')
                        ->select(
                            'inventory.*',
                            'status_barang.deskripsi as is_hapus',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        );
                        $inventory = $inventory->where('inventory.jumlah_barang_keluar', '!=', 0);
                        $inventory = $inventory->Orwhere('inventory.status_barang', '!=', 0);
                        $inventory = $inventory->get();
                        
        return view('report_barang_keluar', compact('jenis_inventory', 'inventory', 'status_barang', 'daftar_barang'));
    }

    public function report_barang_keluar_tampil(Request $request)
    {
        $tanggal_1 = $request->tanggal_1;
        $tanggal_2 = $request->tanggal_2;
        $role_id = Auth::user()->role_id;
        $jenis_inventory = $request->jenis_inventory;
        $status_barang = $request->status_barang;

        $daftar_barang = DB::table('inventory')
                        ->select(
                            'id',
                            'nama_barang',
                            DB::raw('(inventory.jumlah_barang_masuk) - (inventory.jumlah_barang_keluar) as jml_sisa')
                        )
                        ->where('status_barang', '>=', 0)
                        ->having('jml_sisa', '>', 0)
                        ->get();

        $inventory = DB::table('inventory')
                        ->leftjoin('jenis_inventory', 'inventory.jenis_inventory', 'jenis_inventory.id')
                        ->leftjoin('status_barang', 'inventory.status_barang', 'status_barang.id')
                        ->select(
                            'inventory.*',
                            'status_barang.deskripsi as is_hapus',
                            'jenis_inventory.id as id_jenis_inventory',
                            'jenis_inventory.deskripsi as deskripsi_jenis_inventory'
                        );
                        if(!empty($jenis_inventory)){
                            $inventory = $inventory->where('inventory.jenis_inventory', $jenis_inventory);
                        }
                        if(!empty($status_barang)){
                            $inventory = $inventory->where('inventory.status_barang', $status_barang);
                        }
                        if(!empty($tanggal_1)){
                            $inventory = $inventory->whereDate('inventory.tanggal_barang_ditambahkan', '>=', $tanggal_1);
                            $inventory = $inventory->whereDate('inventory.tanggal_barang_ditambahkan', '<=', $tanggal_2);
                        }
                        $inventory = $inventory->where('inventory.jumlah_barang_keluar', '!=', 0);
                        $inventory = $inventory->get();
                        
        return view('report_barang_keluar_tampil', compact('inventory'));
    }

    public function save_input_barang_keluar(Request $request)
    {
        $date_now = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $id_barang = $request->nama_barang;
        $jumlah_barang_keluar = $request->jumlah_barang_keluar;

        $cek_exist = DB::table('inventory')
                    ->select('jumlah_barang_keluar')
                    ->where('id', $id_barang)
                    ->first();
        if($cek_exist->jumlah_barang_keluar < 1){
            $update = [
                'jumlah_barang_keluar' => $jumlah_barang_keluar,
                'tanggal_barang_keluar' => $date_now
            ];
        } 
        else {
            $update = [
                'jumlah_barang_keluar' => $cek_exist->jumlah_barang_keluar+$jumlah_barang_keluar,
                'tanggal_barang_keluar' => $date_now
            ];
        }
        DB::table('inventory')->where('id', $id_barang)->update($update);
        return redirect()->back()->with('status', 'Barang Berhasil Ditambahkan');
    }
}
