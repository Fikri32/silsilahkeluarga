<!doctype html>
<html lang="en">
  <head>

    <!-- Scripts -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

   <!-- Styles -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">


    <title>Silsilah Keluarga</title>
  </head>
  <body>
    <div class="container">
        <button type="button" id="tambah" class="btn btn-primary mt-5 mb-2" data-toggle="modal" data-target="#keluargaModal">Tambah</button>
        <table class="table" id="tbl_list" name = "tbl_list">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Parent ID</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        {{-- Modal --}}
        <div class="modal fade" id="keluargaModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Keluarga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" name="frm_add" id="frm_add" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Kelamin</label>
                            <select name="jk" id="jk" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Orangtua</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">PILIH ORANG TUA</option>
                                @foreach ($parent as $d)
                                    <option value="{{($d->id)}}">{{($d->nama)}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </form>


                <div class="modal-footer">
                    <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
        </div>
 @stack('scripts')
    <script>
        $(document).ready(function () {
        var idEdit = 0

        // button
            $('#tambah').click(function () {

            $('#frm_add').trigger("reset");

            $('#modal-add').modal('show');

            });
        // end button
        // SHOW DATA
            var table = $('#tbl_list').DataTable({
                processing : true,
                serverSide : true,
                ajax       : 'http://localhost:8000/index',
                columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'jk', name: 'jk' },
                { data: 'p_name', name: 'p_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
            })
        // END SHOW DATA

        // STORE DATA
            $('#saveBtn').click(function(){

                var url;
                var type;
                var result;
                if(idEdit == 0)
                {
                    url = 'http://localhost:8000/store'
                    type = 'POST'
                }else{
                    url = 'http://localhost:8000/'+idEdit+'/update'
                    type = 'PUT'
                }
                $.ajax({
                    headers : {
                        'X-CSRF-TOKEN' : "{{csrf_token()}}"
                    },
                    type : type,
                    url : url,
                    data :$('#frm_add').serialize(),
                    success : function(response){
                        if(response.fail != false)
                        {
                            Swal.close();
                            Swal.fire({
                                title   : 'Berhasil!',
                                icon    : 'success',
                                text    : 'Penambahan keluarga Baru Berhasil',
                                showConfirmButton : true
                            })
                        }else{
                            Swal.fire({
                                title   :   'Gagal!',
                                text    :   'Periksa Form Input!',
                                icon    : ' error',
                                showConfirmButton   : true
                            })
                        }
                        idEdit = 0;
                        $('#frm_add').trigger("reset");
                        $('#keluargaModal').modal('hide');
                        table.draw();
                        location.reload();
                    }
                })
            })

        // END STORE DATA

        // EDIT DATA
            $(document).on('click','.edit',function(){
                var id = $(this).attr('data-id');
                console.log(id)
                $.ajax({
                        type:'GET',
                        url: 'http://localhost:8000/'+id+'/edit',
                        success : function(data){
                            // console.log(data)
                            idEdit = data.id;
                            $('#keluargaModal').modal('show');
                            $('#nama').val(data.nama);
                        }
                    })
            })
        // END EDIT DATA

        // DELETE DATA
            $('body').on('click','.hapus',function(){
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: "Anda Yakin?",
                    text: "Data Yang Dihapus Tidak Akan Bisa Dikembalikan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    allowOutsideClick: false,
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            headers:{
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'DELETE',
                            url:'http://localhost:8000/'+id+'/delete',
                            beforeSend:function(){
                                    Swal.fire({
                                        title : 'Tunggu Sebentar...',
                                        text  : 'Data Sedang Di Proses',

                                        showConfirmButton : false,
                                        allowOutsideClick : false,
                                    });
                                },
                            success : function(response){
                                if(response.fail != false)
                                {
                                    Swal.close();
                                    Swal.fire({
                                        title   : 'Berhasil!',
                                        icon    : 'success',
                                        text    : 'Data Berhasil Di Hapus!',
                                        showConfirmButton : true
                                    })
                                }else{
                                    Swal.fire({
                                        title   :   'Gagal!',
                                        text    :   'Data Gagal Di Hapus!',
                                        icon    : 'error',
                                        showConfirmButton   : true
                                    })
                                }

                                table.draw()
                            }
                        })
                    }else{
                        Swal.close()
                    }
                })
            })
            });
        // END DELETE DATA
    </script>


    </body>
</html>
