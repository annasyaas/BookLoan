@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Books</h1>
    </div>
    @if (session()->has('success'))
        <div class="col-lg-8">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ @session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <div>
        <div class="table-responsive col-lg-8">
            <a href="/dashboard/buku/create" class="btn btn-primary mb-3">Create New</a>
            <table class="table table-sm" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>
                                <a href="/dashboard/buku/{{ $book->slug }}" class="badge bg-info">
                                    <span data-feather="eye"></span>
                                </a>
                                <a href="/dashboard/buku/{{ $book->slug }}/edit" class="badge bg-warning">
                                    <span data-feather="edit"></span>
                                </a>
                                <form action="/dashboard/buku/{{ $book->slug }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                                        <span data-feather="trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
