
<table id="datatable" class="table center-aligned-table">
    <thead>
        <tr class="text-primary">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jenis Inventory</th>
            <th>Jumlah Barang Masuk</th>
            <th>Jumlah Sisa Barang</th>
            {{-- <th>Jumlah Barang Keluar</th>
            <th>Sisa Barang</th> --}}
            <th>Harga Barang</th>
            <th>Tanggal Input</th>
            @if(Auth::user()->role_id != '1')
            {{-- <th>Status Barang</th> --}}
            @endif
            <th class="text-center">Aksi</th>
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
            // $total_jml += $inv->jumlah_barang_masuk - $inv->jumlah_barang_keluar;
            $total_jml += $inv->jumlah_barang_diedit;
            $total_harga_barang += (($inv->jumlah_barang_diedit) * $inv->harga_barang);
        @endphp
            <tr class="">
                <td>{{ $no++ }}</td>
                <td>{{ $inv->nama_barang }}</td>
                <td>{{ $inv->deskripsi_jenis_inventory }}</td>
                <td>{{ $inv->jumlah_barang_masuk }}</td>
                <td>{{ $inv->jumlah_barang_diedit }}</td>
                {{-- <td>{{ $inv->jumlah_barang_keluar }}</td>
                <td>{{ $inv->jumlah_barang_masuk-$inv->jumlah_barang_keluar }}</td> --}}
                <td>{{ $inv->harga_barang }}</td>
                <td>{{ \Carbon\Carbon::parse($inv->tanggal_barang_ditambahkan)->format('d-m-Y')}}</td>
                @if(Auth::user()->role_id != '1')
                {{-- <td><label class="badge <?php if($inv->status_barang == 0){ echo 'badge-success'; }else{ echo 'badge-danger';} ?>">{{ $inv->is_hapus }}</label></td> --}}
                @endif
                <td class="text-center">
                    <a href="#" class="m-2 btn btn-outline-primary btn-sm" onclick="detail({{$inv->id}})" data-toggle="modal" data-target="#detailModal">Detail</a>
                    {{-- <br> --}}
                    @if(Auth::user()->role_id == '1')
                    <a href="#" class="m-2 btn btn-outline-warning btn-sm" onclick="edit({{$inv->id}})" data-toggle="modal" data-target="#editModal">Edit</a>
                    {{-- <br> --}}
                    <a href="#" class="m-2 btn btn-outline-danger btn-sm" onclick="hapus({{$inv->id}})" data-toggle="modal" data-target="#hapusModal">Hapus</a>
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