
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
            <th></th>
            @if(Auth::user()->role_id == '1')
            <th></th>
            <th></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @php
            $no=1;
        @endphp
        @foreach($inventory as $inv)
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
                </td>
                @if(Auth::user()->role_id == '1')
                <td>
                    <a href="#" class="btn btn-outline-warning btn-sm" onclick="edit({{$inv->id}})" data-toggle="modal" data-target="#editModal">Edit</a>
                </td>
                <td>
                    <a href="#" class="btn btn-outline-danger btn-sm" onclick="hapus({{$inv->id}})">Hapus</a>
                </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    
    $(document).ready(function () {
            $('#datatable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
</script>