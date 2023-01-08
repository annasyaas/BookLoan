@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Member Page</h1>
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
                <div class="table-responsive col-lg-8">
                    <a href="{{ route('member.create') }}" class="btn btn-primary mb-3">Create New</a>
                    <table class="table table-striped table-sm" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">No. Member</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Institusi</th>
                                <th scope="col" class="text-center" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->member_id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->institution }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('member.edit', $member->id) }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-pencil-alt"></i></a>
                                        <form action="{{ route('member.destroy', $member->id) }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
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
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        })
    </script>
@endpush
