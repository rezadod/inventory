<div class="row">
   <div class="col-4">Nama Barang</div>
   <div class="col-6">{{$inventory->nama_barang}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Jenis Inventory</div>
   <div class="col-6">{{$inventory->deskripsi_jenis_inventory}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Jumlah Barang Masuk</div>
   <div class="col-6">{{$inventory->jumlah_barang_masuk}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Harga Barang</div>
   <div class="col-6">{{$inventory->harga_barang}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Total Harga Barang</div>
   <div class="col-6">{{$inventory->harga_barang*$inventory->jumlah_barang_masuk}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Keterangan</div>
   <div class="col-6">{{$inventory->keterangan_barang}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Tanggal Diedit</div>
   <div class="col-6">{{ \Carbon\Carbon::parse($inventory->tanggal_barang_diedit)->format('d-m-Y')}}</div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Foto Barang</div>
   <div class="col-6">
      <img src="{{ asset('foto_barang/')}}/{{$inventory->foto_barang}}" class="img-fluid" alt="">
   </div>
</div>
   <hr>
<div class="row">
   <div class="col-4">Bukti Transaksi</div>
   <div class="col-6">
      <img src="{{ asset('bukti_tf/')}}/{{$inventory->bukti_transaksi}}" class="img-fluid" alt="">
   </div>
</div>