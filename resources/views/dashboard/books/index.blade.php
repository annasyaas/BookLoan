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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').DataTable({
                ajax: {
                    url: '/getDatas',
                    dataSrc: ''
                },
                columns: [
                    { data: 'number'},
                    { data: 'call_number'},
                    { data: 'title'},
                    { data: 'copy'},
                    { data: 'publisher'},
                    { data: null, render: function(dataField) {
                        return "<button type='button' class='btn btn-sm btn-primary' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-eye'></i></button>" +
                            "<a href='/book/" + dataField['id'] +
                            "/edit' class='btn btn-sm btn-warning'> <i class='fa fa-pencil-alt'></i></a>" +
                            "<a href='javascript:void(0)' class='btn btn-sm btn-danger button' data-id=" +
                            dataField['id'] + ">" +
                            "<i class='fa fa-trash'></i></a>"
                    }}
                ]
            });

            $(document).on('click', '.button', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = "{{ route('bookDelete') }}";
                
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
                                    title: 'Data Buku berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#dataTable').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                })
            })
        });
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
