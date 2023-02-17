@extends('dashboard.layouts.main')
@push('css')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
@endpush
@section('container')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Tambah Peminjaman</h1>
        </div>
        <div class="section-body">
            <div class="col-lg-12">
                <form method="post" action="{{ route('loan.store') }}" class="mb-5">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="memberSelect">Anggota</label>
                                    <select class="form-select form-select-sm" name="member_id" id="memberSelect"
                                        data-placeholder="Pilih Member">
                                        <option value=""></option>
                                        @foreach ($members as $item)
                                            @if (old('member_id') == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->member_id }} | {{ $item->name }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->member_id }} | {{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="bookSelect">Buku</label>
                                    <select class="form-select form-select-sm" name="book_id" id="bookSelect"
                                        data-placeholder="Pilih Buku" onchange="bookFunc(this)">
                                        <option value=""></option>
                                        @foreach ($books as $item)
                                            @if (old('book_id') == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->isbn_issn }} | {{ $item->publisher }} | {{ $item->title }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->isbn_issn }} | {{ $item->publisher }} | {{ $item->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="copy">Sisa Salinan Buku</label>
                                    <input type="text" class="form-control" id="copy">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="copy_code" class="form-label">Kode Eksemplar</label>
                                <input type="text" class="form-control @error('copy_code') is-invalid @enderror"
                                    id="copy_code" name="copy_code" value="{{ old('copy_code') }}" required>
                                @error('copy_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="loan_date" class="form-label">Tanggal Meminjam</label>
                                <input class="form-control" type="date" id="loan_date" name="loan_date" required>
                                @error('loan_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="date_returned" class="form-label">Tanggal Harus Kembali</label>
                                <input class="form-control" type="date" id="date_returned" name="date_returned" required>
                                @error('date_returned')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-lg-12">
                            <a href="{{ route('loan.index') }}" class="btn btn-success text-decoration-none mr-2">
                                <span data-feather="arrow-left"></span> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">Tambah Peminjaman</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#memberSelect').select2();
            $('#bookSelect').select2();
        });

        function bookFunc(obj){
            var id = obj.value;
            var copy = document.getElementById('copy');
            var url = '/getCopy/' + id;

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(data){
                    copy.value = data;
                }
            });

        }
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
@endpush
