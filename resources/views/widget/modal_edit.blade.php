
<form action="{{url('save_edit_barang')}}" method="post" enctype='multipart/form-data'>
   @csrf
   <div class="form-group row">
         <label for="namaBarang" class="col-sm-2 col-form-label">Nama Barang</label>
         <div class="col-sm-10">
            <input value="{{$inventory->nama_barang}}" type="text" class="form-control" id="edit_namaBarang" name="namaBarang" placeholder="Masukkan Nama Barang" readonly >
         </div>
   </div>
   <div class="form-group row">
         <label for="jenisBarang" class="col-sm-2 col-form-label">Jenis Barang</label>
         <div class="col-sm-10">
            <input type="text" value="{{ $inventory->jenis_inventory }}"  class="form-control" id="edit_jenisBarang" name="jenisBarang" readonly hidden>
            <input type="text" value="{{ $inventory->deskripsi }}"  class="form-control" id="edit_jenisBarang_tmpl" name="jenisBarang_tmpl" readonly>
         </div>
   </div>
   <div class="form-group row">
         <label for="jumlahBarang" class="col-sm-2 col-form-label">Jumlah Barang</label>
         <div class="col-sm-10">
            <input value="{{$inventory->jumlah_barang_diedit}}" type="number" class="form-control" id="edit_jumlahBarang" name="jumlahBarang"
               placeholder="Masukkan Jumlah Barang" >
         </div>
   </div>
   <div class="form-group row">
         <label for="hargaBarang" class="col-sm-2 col-form-label">Harga Barang</label>
         <div class="col-sm-10">
            <input readonly value="{{$inventory->harga_barang}}" type="number" class="form-control" id="edit_hargaBarang" name="hargaBarang" placeholder="Masukkan Harga ">

         </div>
   </div>
   <div class="form-group row">
         <label for="keteranganBarang" class="col-sm-2 col-form-label">Keterangan Diedit</label>
         <div class="col-sm-10">
            <textarea class="form-control" name="keteranganBarang" id="keteranganBarang" rows="3" placeholder="Masukkan Keterangan">{{$inventory->keterangan_barang}}</textarea>
         </div>
   </div>
   <div class="form-group row" hidden>
         <label for="fotoBarang" class="col-sm-2 col-form-label">Foto Barang</label>
         <div class="col-sm-10">
            <input type="file" class="form-control" id="edit_fotoBarang" name="fotoBarang" readonly > <span>{{$inventory->foto_barang}}</span>
         </div>
   </div>
   <div class="form-group row" hidden>
         <label for="buktiTransaksi" class="col-sm-2 col-form-label">Bukti Transaksi</label>
         <div class="col-sm-10">
            <input type="file" class="form-control" id="edit_buktiTransaksi" name="buktiTransaksi" readonly > <span>{{$inventory->bukti_transaksi}}</span>
         </div>
   </div>
   <input type="text" name="id" value="{{$inventory->id}}" hidden>
   <input type="text" name="edit_fotoBarangLama" value="{{$inventory->foto_barang}}" hidden>
   <input type="text" name="edit_buktiTransaksiLama" value="{{$inventory->bukti_transaksi}}" hidden>
   <input type="submit" value="" hidden id="edit-btn-submit">
</form>