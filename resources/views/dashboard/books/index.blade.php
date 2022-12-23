@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <section class="section">
        <div class="section-header">
            <h1>Book Page</h1>
        </div>
        <div class="section-body">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ @session('success') }}
                    </div>
                </div>
            @endif
            <div>
                <div class="table-responsive col-lg-12">
                    <a href="{{ route('book.create') }}" class="btn btn-primary mb-3">Create New</a>
                    <table class="table table-sm" id="dataTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th scope="col" width="8%">No</th>
                                <th scope="col">Nomor Panggil</th>
                                <th scope="col" width="30%">Judul</th>
                                <th scope="col">Salin</th>
                                <th scope="col" width="10%">Penerbit</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            $('#dataTable').DataTable({
                // "serverside": true,
                ajax: {
                    url: '/getDatas',
                    dataSrc: ''
                },
                columns: [
                    {data: 'number'},
                    {data: 'call_number'},
                    {data: 'title'},
                    {data: 'copy'},
                    {data: 'publisher'},
                    {data: null, render: function(dataField){
                        return "<button type='button' class='btn btn-sm btn-primary' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-eye'></i></button>" +
                        "<a href='/book/" + dataField['id'] + "/edit' class='btn btn-sm btn-warning'> <i class='fa fa-pencil-alt'></i></a>"+
                        "<form class='formSubmit' action='' method='post' ><button class='btn btn-sm btn-danger'>Delete</button></form>" 
                        // "<a href='' class='btn btn-sm btn-danger button'>"+
                        // "<i class='fa fa-trash'></i></a>"
                    }}
                ]
            });

            $('.button').click(function(){
                alert('Mau');
            })

            $('.formSubmit').submit(function(){
                alert('Mau');
            })
        });

        function deleteData(id, e){
            // e.preventDefault();
            var url = "book/delete/"+id;
            alert(url);
            $.ajax({
                headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "post",
                data:{
                    _method: "delete"
                },
                success: function(data){
                    alert(data.message + " berhasil");
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function(data){
                    alert(data + " gagal");
                }
            });
        }

        
    </script>

    {{-- <script>
       
    </script> --}}

    <script>
        // $('table').on('click', '.btnDelete', function(){
        //     var id = $(this).attr('id');
        //     console.log(id);
        // });
    </script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
