
<table id="datatable" class="table center-aligned-table">
    <thead>
        <tr class="text-primary">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jenis Inventory</th>
            <th>Jumlah Barang</th>
            <th>Harga Barang</th>
            <th>Tanggal Input</th>
            @if(Auth::user()->role_id != '1')
            <th>Status Barang</th>
            @endif
            <th>Aksi</th>
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
                $col = 5;
            }
        @endphp
        @foreach($inventory as $inv)
        @php
            $total_jml += $inv->jumlah_barang;
            $total_harga_barang += ($inv->jumlah_barang * $inv->harga_barang);
        @endphp
            <tr class="">
                <td>{{ $no++ }}</td>
                <td>{{ $inv->nama_barang }}</td>
                <td>{{ $inv->deskripsi_jenis_inventory }}</td>
                <td>{{ $inv->jumlah_barang }}</td>
                <td>{{ $inv->harga_barang }}</td>
                <td>{{ $inv->created_at }}</td>
                @if(Auth::user()->role_id != '1')
                <td><label class="badge <?php if($inv->status_hapus == 0){ echo 'badge-success'; }else{ echo 'badge-danger';} ?>">{{ $inv->is_hapus }}</label></td>
                @endif
                <td>
                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="detail({{$inv->id}})" data-toggle="modal" data-target="#detailModal">Detail</a>
                @if(Auth::user()->role_id == '1')
                    <a href="#" class="btn btn-outline-warning btn-sm" onclick="edit({{$inv->id}})" data-toggle="modal" data-target="#editModal">Edit</a>
                
                    <a href="#" class="btn btn-outline-danger btn-sm" onclick="hapus({{$inv->id}})">Hapus</a>
                </td>
                @endif
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{{ $col }}"></td>
            <td class="bg-info text-white">Jumlah Total Barang</td>
            <td class="bg-info text-white">{{ number_format($total_jml) }}</td>
            <td class="bg-info text-white">Jumlah Total Harga</td>
            <td class="bg-info text-white">{{ number_format($total_harga_barang,0, ',','.') }}</td>
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