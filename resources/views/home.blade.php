@extends('layouts.app')

@section('content')
    <h3 class="page-heading mb-4">Dashboard</h3>
    @if(Auth::user()->role_id == '1')
    <div class="row">
        <a href="#" class="btn btn-success btn-sm p-2 mb-4 ml-3 text-white" data-toggle="modal"
            data-target="#inputModal">Input Barang</a>
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
    </div>
    <div class="card-deck">
        <div class="card col-lg-12 px-0 mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table center-aligned-table">
                        <thead>
                            <tr class="text-primary">
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jenis Inventory</th>
                                <th>Jumlah Barang</th>
                                <th>Harga Barang</th>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Input -->
    <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('save_input_barang')}}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">Input Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="namaBarang" class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="namaBarang" name="namaBarang" placeholder="Masukkan Nama Barang">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenisBarang" class="col-sm-2 col-form-label">Jenis Barang</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="jenisBarang" name="jenisBarang">
                                    <option value="">-- Pilih Jenis Barang --</option>
                                    @foreach($jenis_inventory as $data)
                                    <option value="{{$data->id}}">{{$data->deskripsi}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlahBarang" class="col-sm-2 col-form-label">Jumlah Barang</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="jumlahBarang" name="jumlahBarang"
                                    placeholder="Masukkan Jumlah Barang">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hargaBarang" class="col-sm-2 col-form-label">Harga Barang</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="hargaBarang" name="hargaBarang" placeholder="Masukkan Harga ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fotoBarang" class="col-sm-2 col-form-label">Foto Barang</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="fotoBarang" name="fotoBarang">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="buktiTransaksi" class="col-sm-2 col-form-label">Bukti Transaksi</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="buktiTransaksi" name="buktiTransaksi">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success text-white" onclick="validate()">Simpan</button>
                        <input type="submit" value="" hidden id="btn-submit">
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
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script>
        function validate(){
            var nama_barang = $("#namaBarang").val();
            var jenis_barang = $("#jenisBarang :selected").val();
            var jumlah_barang = $("#jumlahBarang").val();
            var harga_barang = $("#hargaBarang").val();
            var foto_barang = $("#fotoBarang").val();
            var bukti_tf = $("#buktiTransaksi").val();

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
            }else if(foto_barang == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Foto Barang Tidak Boleh Kosong!',
                })
            }else if(bukti_tf == ''){
                Swal.fire({
                    icon: 'error',
                    text: 'Bukti Transfer Tidak Boleh Kosong!',
                })
            }else{
                $('#btn-submit').click();
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
                var token = '{{ csrf_token() }}';
                var my_url = "{{url('/cek_produk')}}";
                var formData = {
                    '_token': token, 
                    'nama_barang': nama_barang, 
                    'harga_barang': harga_barang
                };
                $.ajax({
                    method: 'POST',
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function(resp){
                        $.each(resp, function(i,n){
                            if(n['harga_barang'] != harga_barang){
                                alert('Mohon maaf Data Produk Berbeda, Silahkan Input Data Baru!');
                            }
                            else{
                                $('#edit-btn-submit').click();
                            }
                        });
                    },
                    error: function (resp){
                        console.log(resp);
                    }
                });
            }
        }

        function hapus(id){
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
