

<table id="datatable" class="table center-aligned-table">
    <thead>
        <tr class="text-primary">
           <th>No</th>
                                <th>Foto Barang</th>
                                <th>Bukti Transaksi</th>
                                <th>Nama Barang</th>
                                <th>Jenis Inventory</th>
                                <!-- <th>Jumlah Barang Masuk</th> -->
                                <th>Jumlah Barang Keluar</th>
                                <!-- <th>Sisa Barang</th> -->
                                <th>Harga Barang</th>
                                <th>Tanggal Keluar</th>
                                <th>Status Barang</th>
                                <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
            $total_jml=0;
            $total_harga_barang=0;
            if(Auth::user()->role_id != 1){
                $col = 5;
            }
            else {
                $col = 5;
            }
        @endphp
        @foreach($inventory as $inv)
        @php
            $total_jml += $inv->jumlah_barang_keluar;
            $total_harga_barang += ($inv->jumlah_barang_keluar * $inv->harga_barang);
        @endphp
           <tr class="">
                                    <td>{{ $no++ }}</td>
                                    <td> <img class="mb-2 rounded-3" id="barang" style="width: 100px;height: 100px" id="blah"
                                    src="foto_barang/{{$inv->foto_barang}}"></td>
                                    <td> <img class="mb-2 rounded-3" id="barang" style="width: 100px;height: 100px" id="blah"
                                    src="bukti_tf/{{$inv->bukti_transaksi}}"></td>

                                    <td>{{ $inv->nama_barang }}</td>
                                    <td>{{ $inv->deskripsi_jenis_inventory }}</td>
                                    <!-- <td>{{ $inv->jumlah_barang_masuk }}</td> -->
                                    <td>{{ $inv->jumlah_barang_keluar }}</td>
                                    <!-- <td>{{ $inv->jumlah_barang_masuk-$inv->jumlah_barang_keluar }}</td> -->
                                    <td>{{ $inv->harga_barang }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inv->tanggal_barang_keluar)->format('d-m-Y')}}</td>
                                    <td><label class="badge <?php if($inv->status_barang == 1){ echo 'badge-danger'; }else if($inv->status_barang == 2){ echo 'badge-warning'; }else{ echo 'badge-info';} ?>">{{ $inv->is_hapus }}</label></td>
                                    <td>{{ $inv->keterangan_barang }}</td>
                                </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td colspan="{{ $col }}"></td>
            <td class="bg-warning text-white">Jumlah Total Barang</td>
            <td class="bg-warning text-white">{{ number_format($total_jml) }}</td>
            <td class="bg-warning text-white">Jumlah Total Harga</td>
            <td class="bg-warning text-white">{{ number_format($total_harga_barang,0, ',','.') }}</td>
        </tr>
    </tfoot>
</table>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                { extend: 'print', footer: true },
                { extend: 'pdf', footer: true },
                'copy', 'csv', 'excel'
            ]
        });
    });
</script>