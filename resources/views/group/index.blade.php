@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">List Member</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-info btn-sm" id="add"><i class="fa fa-plus"></i> Tambah Member</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Group</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form" method="post" enctype="multipart/form-data" action="{{ route('member.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control member_id" name="id" id="member_id" hidden>
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                            <div class="text-danger" id="error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Group</label>
                            <select type="text" class="form-control" name="group_id" id="group_id"
                                placeholder="Enter group_id">
                                <option value="" hidden selected>Pilih Group</option>
                                @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }} | {{ $group->city }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="error-group_id"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Enter address">
                            <div class="text-danger" id="error-address"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Telepon</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone">
                            <div class="text-danger" id="error-phone"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                            <div class="text-danger" id="error-email"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Foto</label>
                            <input type="file" class="form-control" name="file" id="file" placeholder="Enter picture">
                            <div class="text-danger" id="error-file"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" id="save" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('css')
<link href="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
    // show data on page load
    table()
  function table(){
  var ta =  $('#dataTable').DataTable({
        ajax: '{{ route("member.data") }}',
        columns: [
            { data: 'name' },
            { data: 'group.name' },
            { data: 'address' },
            { data: 'phone' },
            { data: 'email' },
            { data: 'picture' },
            { data: 'id' },
        ],
        columnDefs: [
            { targets: 5,
                render: function(data) {
                    return '<img src="{{ asset("storage/member") }}/'+data+'" width="100px">'
                }
            },
            { targets: 6,
                render: function(id) {
                    return `
                    <button class="btn btn-info edit"><i class="fa fa-edit"></i></button>
                    `
                }
            }   
        ]
    });
    
    $("#dataTable tbody").on("click","button", function () {
        var data= ta.row($(this).parents('tr')).data();
        console.log(data.id);
        $("#data").modal("show");
        $("#title").text("Edit " + data.name);
        $("#save").text("Update Data");
        // form
        $("#name").val(data.name);
        $("#group_id").val(data.group_id);
        $("#address").val(data.address);
        $("#phone").val(data.phone);
        $("#email").val(data.email);
        $(".member_id").val(data.id);
        $("#file").val(data.picture);
    });
   }


   $("#add").click(function (e) { 
        e.preventDefault();
        $("#data").modal("show");
        $("#title").text("Tambah Member");
        $("#save").text("Simpan");
        // form
        $("#name").val("");
        $("#group_id").val("");
        $("#address").val("");
        $("#phone").val("");
        $("#email").val("");
        $("#file").val("");
        $("#member_id").val("");
   });

   $("#save").click(function (e) { 
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: form.action,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                // sweetalert
                if (data.status == true) {
                    $("#data").modal("hide");
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan!',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                    setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                    }, 1000);
                }else{
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Telah terjadi kesalahan',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });

                    $.each(data.error, function (key, value) {
                        //   show errors
                        $('#' + key).addClass('is-invalid');
                        $('#' +'error-' + key ).html(value);
                        // hide error
                        $('#' + key).on('keyup', function () {
                            $('#' + key).removeClass('is-invalid');
                            $('#' +'error-' + key ).html('');
                        });
                    });
                }
            }
        });
     
   });


  });
</script>
@endsection