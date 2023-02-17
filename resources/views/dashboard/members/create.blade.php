@extends('dashboard.layouts.main')

@section('container')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Tambah Anggota</h1>
        </div>
        <div class="section-body">
            <div class="col-lg-12">
                <form method="post" action="{{ route('member.store') }}" class="mb-5">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Nomor Anggota</label>
                                <input type="text" class="form-control @error('member_id') is-invalid @enderror" id="member_id"
                                    name="member_id" value="{{ old('member_id') }}" required autofocus>
                                @error('member_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Anggota</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="institution" class="form-label">Institusi</label>
                                <input type="text" class="form-control @error('institution') is-invalid @enderror" id="institution"
                                    name="institution" value="{{ old('institution') }}" required>
                                @error('institution')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-lg-12">
                            <a href="{{ route('member.index') }}" class="btn btn-success text-decoration-none mr-2">
                                <span data-feather="arrow-left"></span> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">Tambah Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
