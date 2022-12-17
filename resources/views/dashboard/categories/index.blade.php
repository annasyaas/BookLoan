@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Book Categories</h1>
    </div>
    @if (session()->has('success'))
        <div class="col-lg-6">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ @session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <div>
        <div class="table-responsive col-lg-6">
            <a href="/dashboard/categories/create" class="btn btn-primary mb-3">Create New</a>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="text-center">
                                <a href="/dashboard/categories/{{ $category->slug }}" class="badge bg-info">
                                    <span data-feather="eye"></span>
                                </a>
                                <a href="/dashboard/categories/{{ $category->slug }}/edit" class="badge bg-warning">
                                    <span data-feather="edit"></span>
                                </a>
                                <form action="/dashboard/categories/{{ $category->slug }}" method="post" class="d-inline">
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