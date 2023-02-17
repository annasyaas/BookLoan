@extends('dashboard.layouts.main')
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Halaman Detail Buku</h1>
        </div>
        <div class="section-body">
            <div class="col-lg-11" style="margin-left: 50px; margin-top: 60px">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="call_number" class="form-label">Nomor Panggil Buku</label>
                            <input type="text" class="form-control text-primary"
                                id="call_number" name="call_number" value="{{ $book->call_number }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control text-primary" id="title"
                                name="title" value="{{ $book->title }}" readonly disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label for="copy" class="form-label">Jumlah Salin Buku</label>
                            <input type="number" min="1" class="form-control text-primary"
                                id="copy" name="copy" value="{{ $book->copy }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="publish_place" class="form-label">Tempat Terbit Buku</label>
                            <input type="text" class="form-control text-primary"
                                id="publish_place" name="publish_place"
                                value="{{ $book->publish_place }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="publisher" class="form-label">Penerbit Buku</label>
                            <input type="text" class="form-control text-primary"
                                id="publisher" name="publisher" value="{{ $book->publisher }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="isbn_issn" class="form-label">ISBN/ISSN Buku</label>
                            <input type="text" class="form-control text-primary"
                                id="isbn_issn" name="isbn_issn" value="{{ $book->isbn_issn }}" readonly disabled>
                        </div>
                    </div>
                </div>
                <div class="row text-center mt-5">
                    <div class="col-lg-12">
                        <a href="{{ route('book.index') }}" class="btn btn-success text-decoration-none mr-2">
                            <span data-feather="arrow-left"></span> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
