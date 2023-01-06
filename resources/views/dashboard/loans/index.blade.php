@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <div class="section">
        <div class="section-header text-center">
            <h1>Loan Page</h1>
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
                    <a href="{{ route('loan.create') }}" class="btn btn-primary mb-3">Create New</a>
                    <table class="table table-sm table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col" width="3%">No</th>
                                <th scope="col">No. Member</th>
                                <th scope="col">Nama Member</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Kode Eksemplar</th>
                                <th scope="col" width="10%">Tgl Pinjam</th>
                                <th scope="col" width="10%">Tgl Harus Kembali</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center" width="7%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $loan->member->member_id }}</td>
                                    <td>{{ $loan->member->name }}</td>
                                    <td>{{ $loan->book->title }}</td>
                                    <td>{{ $loan->copy_code }}</td>
                                    <td>{{ $loan->loan_date }}</td>
                                    <td>{{ $loan->date_returned }}</td>
                                    <td class="mr-auto ml-auto d-block">
                                        <div class="form-group">
                                            <label class="custom-switch mt-0 pl-0">
                                                @if ($loan->status == 1)
                                                    <input type="checkbox"
                                                        onclick="statusFunc(this, {{ $loan->id }}, {{ $loan->book->id }})"
                                                        class="custom-switch-input" checked>
                                                @else
                                                    <input type="checkbox"
                                                        onclick="statusFunc(this, {{ $loan->id }}, {{ $loan->book->id }})"
                                                        class="custom-switch-input">
                                                @endif
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('loan.edit', $loan->id) }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-pencil-alt"></i></a>
                                        <button class="btn btn-sm btn-danger button" data-id="{{ $loan->id }}"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $(document).on('click', '.button', function() {
                var id = $(this).data('id');
                var url = "/loan/"+id;

                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            dataSrc: '',
                            data: {
                                id: id,
                                _method: 'delete',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data Buku berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function(){
                                    location.reload();
                                });
                            }
                        });
                    }
                })
            })
        })

        function statusFunc(obj, id, book) {

            if (obj.checked) {
                $.ajax({
                    url: "{{ route('book.copy.update') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: id,
                        copy: 1,
                        book: book,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.reload();
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('book.copy.update') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: id,
                        copy: 0,
                        book: book,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        }
    </script>
@endpush
