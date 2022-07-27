@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">List user</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @permission('users-create')
            <button class="btn btn-info btn-sm" id="add"><i class="fa fa-plus"></i> Tambah user</button>
            @endpermission
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
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
                <form id="form" method="post" enctype="multipart/form-data" action="{{ route('user.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control user_id" name="id" id="user_id" hidden>
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                            <div class="text-danger" id="error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Group</label>
                            <select type="text" class="form-control" name="role" id="role" placeholder="Enter group_id">
                                <option value="" hidden selected>Pilih Group</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="error-role"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                            <div class="text-danger" id="error-email"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Password">
                            <div class="text-danger" id="error-password"></div>
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
        ajax: '{{ route("user.data") }}',
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'role.name' },
            { data: 'id' },
        ],
        columnDefs: [
            { targets: 3,
                render: function(id) {
                    return `
                    @permission('users-update')
                    <button class="btn btn-info edit"><i class="fa fa-edit"></i></button>
                    @endpermission
                    @permission('users-delete')
                    <button class="btn btn-danger delete" data-id"${id}"><i class="fa fa-trash"></i></button>
                    @endpermission
                    `
                }
            }   
        ]
    });
    
    $("#dataTable tbody").on("click",".edit", function () {
        var data= ta.row($(this).parents('tr')).data();
        console.log(data.id);
        $("#data").modal("show");
        $("#title").text("Edit " + data.name);
        $("#save").text("Update Data");
        // form
        $("#name").val(data.name);
        $("#role").val(data.role_id);
        $("#email").val(data.email);
        $(".user_id").val(data.id);
        $("#password").val("");
    });

    $("#dataTable").on("click",'.delete', function(){
        var data= ta.row($(this).parents('tr')).data();
        let url = "{{ route('user.destroy',':id') }}";
        url = url.replace(':id',data.id);
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: data.name + " akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                success: function (data) {
                    if(data.status == true){
                        Swal.fire({
                            customClass: {
                                container: 'my-swal'
                            },
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                            // reset data
                        setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                        }, 1000);
                    }else{
                        Swal.fire(
                            'Gagal!',
                             data.message,
                            'error'
                            )
                        }
                    }
                });
            }
        });
    });

   }


   $("#add").click(function (e) { 
        e.preventDefault();
        $("#data").modal("show");
        $("#title").text("Tambah user");
        $("#save").text("Simpan");
        // form
        $("#name").val("");
        $("#role").val("");
        $("#email").val("");
        $("#user_id").val("");
        $("#password").val("");
   });

   $("#import_open").click(function (e) { 
        e.preventDefault();
        $("#import").modal("show");
        $("#title").text("Import user");
        $("#button_import").text("Simpan");
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