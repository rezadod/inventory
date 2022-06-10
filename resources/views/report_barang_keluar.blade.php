@extends('layouts.app')

@section('content')
    <h3 class="page-heading mb-4">Report Barang Keluar</h3>
    @if(Auth::user()->role_id == '1')
    <div class="row">
        <a href="#" class="btn btn-danger btn-sm p-2 mb-4 ml-3 text-white" data-toggle="modal"
            data-target="#inputModal">Barang Keluar</a>
    </div>
    @endif
    <div class="row ml-1">
        @if (session('edit'))
            <div class="alert alert-warning">
                {{ session('edit') }}
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('hapus'))
            <div class="alert alert-danger">
                {{ session('hapus') }}
            </div>
        @endif
    </div>
    <div class="card-deck">
        <div class="card col-lg-12 px-0 mb-4">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-2">
                        <div>
                            <label for="jenis_inventory">Jenis Inventory</label>
                        </div>
                        <div>
                            <select name="jenis_inventory" id="jenis_inventory" class="form-control">
                                <option value="">SEMUA</option>
                                @foreach($jenis_inventory as $k)
                                <option value="{{$k->id}}">{{$k->deskripsi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            <label for="status_barang">Status Barang</label>
                        </div>
                        <div>
                            <select name="status_barang" id="status_barang" class="form-control">
                                <option value="">SEMUA</option>
                                @foreach($status_barang as $k)
                                <option value="{{$k->id}}">{{$k->deskripsi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div>
                            <label for="tanggal_1">Tanggal Keluar 1</label>
                        </div>
                        <div>
                            <input type="date" class="form-control" id="tanggal_1" name="tanggal_1">
                        </div>
                    </div>
                    <div class="col-3">
                        <div>
                            <label for="tanggal_2">Tanggal Keluar 2</label>
                        </div>
                        <div>
                            <input type="date" class="form-control" id="tanggal_2" name="tanggal_2">
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            <span style="color: white">-</span>
                        </div>
                        <div>
                            <a class="btn btn-warning btn-md text-white mt-2 btn-rounded" onclick="cari_data(2)"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" id="tampil_search">
                    <table id="datatable" class="table center-aligned-table">
                        <thead>
                            <tr class="text-primary">
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jenis Inventory</th>
                                <th>Jumlah Barang</th>
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
                                    $col = 2;
                                }
                                else {
                                    $col = 2;
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
                                    <td>{{ $inv->jumlah_barang_keluar }}</td>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Input -->
    <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('save_input_barang_keluar')}}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">Input Barang Keluar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="nama_barang" name="nama_barang">
                                    <option value="">-- Pilih Nama Barang --</option>
                                    @foreach($daftar_barang as $data)
                                    <option value="{{$data->id}}">{{$data->nama_barang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_barang_keluar" class="col-sm-2 col-form-label">Jumlah Barang Keluar</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="jumlah_barang_keluar" name="jumlah_barang_keluar"
                                    placeholder="Masukkan Jumlah Barang">
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success text-white" onclick="validate_input()">Simpan</button>
                        <button type="submit" id="tombol_input" hidden></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="bodyEditModal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success text-white" onclick="validate_edit()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Hapus Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="bodyHapusModal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger text-white" onclick="validate_hapus()">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal" id="detailModal" tabindex="9999" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Detail Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="bodyDetailModal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

@push('add_js')
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
        
        function cari_data(){
            var tanggal_1 = $('#tanggal_1').val();
            var tanggal_2 = $('#tanggal_2').val();
            var status_barang = $('#status_barang').val();
            var jenis_inventory = $('#jenis_inventory').val();
            var token = '{{ csrf_token() }}';
            var my_url = "{{url('/report_barang_keluar')}}";
            var formData = {
                '_token': token,
                'tanggal_1': tanggal_1,
                'tanggal_2': tanggal_2,
                'status_barang': status_barang,
                'jenis_inventory': jenis_inventory
            };
            $.ajax({
                method: 'POST',
                url: my_url,
                data: formData,
                success: function(resp){
                    $("#tampil_search").html(resp);
                },
                error: function (resp){
                    console.log(resp);
                }
            });
        }
        function validate_input(){
            var nama_barang = $("#nama_barang").val();
            var jumlah_barang = $("#jumlah__barang_keluar").val();
            var ket_barang = $("#ket_barang").val();

            if(nama_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Nama Barang Tidak Boleh Kosong!',
                })
            }else if(jumlah_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Jumlah Barang Tidak Boleh Kosong!',
                })
            }else{
                $('#tombol_input').click();
            }
        }

        function validate_edit(){
            var nama_barang = $("#edit_namaBarang").val();
            var jenis_barang = $("#edit_jenisBarang :selected").val();
            var jumlah_barang = $("#edit_jumlahBarang").val();
            var harga_barang = $("#edit_hargaBarang").val();
            var keterangan_barang = $("#keteranganBarang").val();
            var foto_barang = $("#edit_fotoBarang").val();
            var bukti_tf = $("#edit_buktiTransaksi").val();

            if(nama_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Nama Barang Tidak Boleh Kosong!',
                })
            }else if(jenis_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Jenis Barang Tidak Boleh Kosong!',
                })
            }else if(jumlah_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Jumlah Barang Tidak Boleh Kosong!',
                })
            }else if(harga_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Harga Barang Tidak Boleh Kosong!',
                })
            }else if(keterangan_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Keterangan Tidak Boleh Kosong!',
                })
            }else{
                $('#edit-btn-submit').click();
            }
        }
        function validate_hapus(){
            var keterangan_barang = $("#keteranganBarang").val();

            if(keterangan_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Keterangan Tidak Boleh Kosong!',
                })
            }else{
                $('#hapus-btn-submit').click();
            }
        }

        function hapus2(id){
            console.log(id);
            const { value: text} = Swal.fire({
            input: 'textarea',
            inputLabel: 'Message',
            inputPlaceholder: 'Type your message here...',
            inputAttributes: {
                'aria-label': 'Type your message here'
            },
            showCancelButton: true
            })

            if (text) {
            Swal.fire(text)
            }
            // Swal.fire({
            //         title: 'Anda Yakin?',
            //         text: "Data inventory yang dihapus tidak dapat dikembalikan kembali!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         cancelButtonText: 'Batal',
            //         confirmButtonText: 'Ya, Hapus!'
            //     }).then((result) => {
            //     if (result.isConfirmed) {
            //         var token = '{{ csrf_token() }}';
            //         $.ajax({
            //             method: "post",
            //             url: "{{url('/hapus_inventory')}}",
            //             data: {
            //                 '_token': token,
            //                 'id': id
            //             },
            //             success: function (resp) {
            //                 Swal.fire({
            //                     icon: 'success',
            //                     text: 'Data berhasil dihapus!',
            //                 });
            //                 location.reload();
            //             },
            //             error: function (resp) {
            //                 console.log(resp);
            //                 Swal.fire({
            //                     icon: 'error',
            //                     text: 'Data gagal dihapus!',
            //                 });
            //                 location.reload();
            //             }
            //         });
            //     }
            // });
        }

        function hapus(id){
            var token = '{{ csrf_token() }}';
            $.ajax({
                method: "post",
                url: "{{url('/hapus_data_inventory')}}",
                data: {
                    '_token': token,
                    'id': id
                },
                success: function (resp) {
                    // $('#hapusModal').modal('show');
                    $("#bodyHapusModal").html(resp);
                },
                error: function (resp) {
                    console.log(resp);
                    Swal.fire({
                        icon: 'error',
                        text: 'Upss ada yang error, hubungi tim IT!',
                    });
                }
            });
        }
        function edit(id){
            var token = '{{ csrf_token() }}';
            $.ajax({
                method: "post",
                url: "{{url('/edit_inventory')}}",
                data: {
                    '_token': token,
                    'id': id
                },
                success: function (resp) {
                    $("#bodyEditModal").html(resp);
                },
                error: function (resp) {
                    console.log(resp);
                    Swal.fire({
                        icon: 'error',
                        text: 'Upss ada yang error, hubungi tim IT!',
                    });
                }
            });
        }

        function detail(id){
            var token = '{{ csrf_token() }}';
            $.ajax({
                method: "post",
                url: "{{url('/detail_inventory')}}",
                data: {
                    '_token': token,
                    'id': id
                },
                success: function (resp) {
                    $("#bodyDetailModal").html(resp);
                },
                error: function (resp) {
                    console.log(resp);
                    Swal.fire({
                        icon: 'error',
                        text: 'Upss ada yang error, hubungi tim IT!',
                    });
                }
            });
        }
    </script>
@endpush

@endsection
