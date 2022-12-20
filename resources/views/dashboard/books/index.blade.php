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
                    <a href="/book/create" class="btn btn-primary mb-3">Create New</a>
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        var t = $('#dataTable').DataTable({
            "serverside": true,
            ajax: {
                url: '/getDatas',
                dataSrc: ''
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'call_number'
                },
                {
                    data: 'title'
                },
                {
                    data: 'copy'
                },
                {
                    data: 'publisher'
                },
                {
                    data: 'action'
                }
            ]
        });

        // t.on('draw.dt', function(){
        // var PageInfo = $('#example').DataTable().page.info();
        //     t.column(0, { page: 'current'}).nodes().each(function(cell, i){
        //         cell.innerHTML = i + 1;
        //     });
        // });
    </script>
@endpush
