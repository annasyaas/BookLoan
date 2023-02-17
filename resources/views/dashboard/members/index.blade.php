@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Halaman Anggota</h1>
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
            @elseif (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ @session('failed') }}
                    </div>
                </div>
            @endif
            <div>
                <div class="table-responsive col-lg-12">
                    <a href="{{ route('member.create') }}" class="btn btn-primary mb-3">Buat Baru</a>
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">No. Anggota</th>
                                <th scope="col">Nama Anggota</th>
                                <th scope="col">Institusi</th>
                                <th scope="col" class="text-center" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                ajax: {
                    url: '{{ route('getmember') }}',
                    dataSrc: ''
                },
                columns: [
                    { data: 'number'},
                    { data: 'member_id'},
                    { data: 'name'},
                    { data: 'institution'},
                    { data: null, render: function(dataField) {
                        return '<a href="/member/'+ dataField["id"] +'" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat Rekomendasi">'+
                            '<i class="fa fa-eye"></i></a> <a href="/member/'+ dataField["id"] +'/edit" class="btn btn-sm btn-warning mr-1"><i class="fa fa-pencil-alt"></i></a>' +
                            '<a href="javascript:void(0)" class="btn btn-sm btn-danger button" data-id= '+ dataField["id"] + ">" +
                            '<i class="fa fa-trash"></i></a>'
                    }}
                ]
            });

            $(document).on('click', '.button', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = "{{ route('memberDelete') }}";
                
                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id,
                                _method: 'delete',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data Member berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#dataTable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                })
            })
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        })
    </script>
@endpush
