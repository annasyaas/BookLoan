@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Buku</h1>
    </div>
    <div>
        <article>
            <h3 class="mb-3"><b>{{ $buku->judul }}</b></h3>
            <a href="/dashboard/buku" class="badge btn-success text-decoration-none">
                <span data-feather="arrow-left"></span> Back to my post
            </a>
            <a href="/dashboard/buku/{{ $buku->slug }}/edit" class="badge btn-warning text-decoration-none">
                <span data-feather="edit"></span> Edit
            </a>
            <form action="/dashboard/buku/{{ $buku->slug }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                    <span data-feather="trash"></span> Delete
                </button>
            </form>
            <div class="col-lg-8">
                <p class="mt-3">{!! $buku->desc !!}</p>
            </div>
        </article>
    </div>
@endsection
