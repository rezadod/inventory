
<table id="datatable" class="table center-aligned-table">
    <thead>
        <tr class="text-primary">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jenis Inventory</th>
            <th>Jumlah Barang Masuk</th>
            <th>Jumlah Barang Keluar</th>
            <th>Sisa Barang</th>
            <th>Harga Barang</th>
            <th>Tanggal Keluar</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
            $total_jml=0;
            $total_harga_barang=0;
            if(Auth::user()->role_id != 1){
                $col = 4;
            }
            else {
                $col = 4;
            }
        @endphp
        @foreach($inventory as $inv)
        @php
            $total_jml += $inv->jumlah_barang_keluar;
            $total_harga_barang += ($inv->jumlah_barang_keluar * $inv->harga_barang);
        @endphp
            <tr class="">
                <td>{{ $no++ }}</td>
                <td>{{ $inv->nama_barang }}</td>
                <td>{{ $inv->deskripsi_jenis_inventory }}</td>
                <td>{{ $inv->jumlah_barang_masuk }}</td>
                <td>{{ $inv->jumlah_barang_keluar }}</td>
                <td>{{ $inv->jumlah_barang_masuk-$inv->jumlah_barang_keluar }}</td>
                <td>{{ $inv->harga_barang }}</td>
                <td>{{ $inv->tanggal_barang_keluar }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
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