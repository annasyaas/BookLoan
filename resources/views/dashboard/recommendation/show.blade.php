@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/loading.css') }}">
@endpush
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Halaman Rekomendasi</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mb-3 ">Matriks User x Item</h4>
                    <div class="table-responsive" style="overflow-x: scroll; overflow-y: scroll; height: 500px">
                        <table class="table table-sm text-center" style="width: 100%" border="1">
                            <tr>
                                <td>#</td>
                                @foreach (array_keys(current($dataMatrix)) as $book)
                                    <td><b>{{ $book }}</b></td>
                                @endforeach
                            </tr>
                            @foreach (array_keys($dataMatrix) as $user)
                                <tr>
                                    <td><b>{{ $user }}</b></td>
                                    @foreach (array_keys($dataMatrix[$user]) as $book)
                                        <td>{{ $dataMatrix[$user][$book] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-lg-3 text-center">
                    <a href="javascript:void(0)" class="btn btn-primary" id="simBtn">Lihat Nilai Similarity</a>
                </div>
            </div>
            <div class="lds-roller ml-auto mr-auto mt-5" id="loadsim">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="row" id="similarity">
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Similarity Item</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="simTableBook" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Buku ke-1</td>
                                    <td>ID Buku ke-2</td>
                                    <td>Nilai Similarity</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Similarity User</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="simTableMember" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Anggota ke-1</td>
                                    <td>ID Anggota ke-2</td>
                                    <td>Nilai Similarity</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-2 text-center">
                    <a href="javascript:void(0)" class="btn btn-primary" id="predBtn">Lihat Rekomendasi</a>
                </div>
            </div>
            <div class="lds-roller ml-auto mr-auto mt-5" id="loadpred">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="row" id="prediction">
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Prediksi Item-Based</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="predTableBook" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Anggota</td>
                                    <td>ID Buku</td>
                                    <td>Nilai Prediksi</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Prediksi User-Based</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="predTableMember" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Anggota</td>
                                    <td>ID Buku</td>
                                    <td>Nilai Prediksi</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-2 text-center">
                    <a href="{{ route('getmaemape') }}" class="btn btn-primary" id="btnMae">Lihat Mae</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#similarity').hide();
        $('#prediction').hide();
        $('#predBtn').hide();
        $('#loadsim').hide();
        $('#loadpred').hide();
        $('#btnMae').hide();
        $(document).ready(function() {

            $('#simBtn').click(function() {
                $('#loadsim').show();
                $('#simBtn').hide();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('getsimilarity') }}',
                    success: function(datas) {
                        $('#loadsim').hide();
                        $.each(datas, function(method, methodValue) {
                            if (method == 'itemSim') {
                                $.each(methodValue, function(book_1, books) {
                                    $.each(books, function(book_2, value) {
                                        tablebooksim = $(
                                                '#simTableBook')
                                            .DataTable();
                                        tablebooksim.row.add([book_1,
                                            book_2, value
                                        ]).draw().node();
                                    })
                                })
                            } else if (method == 'memberSim') {
                                $.each(methodValue, function(member_1, members) {
                                    $.each(members, function(member_2, value) {
                                        tablemembersim = $(
                                                '#simTableMember')
                                            .DataTable();
                                        tablemembersim.row.add([
                                            member_1, member_2,
                                            value
                                        ]).draw().node();
                                    })
                                })
                            }
                        })
                    }
                })
                .done(function(response){
                    $('#similarity').show();
                    $('#predBtn').show();
                });
            })

            $('#predBtn').click(function() {
                $('#loadpred').show();
                $('#predBtn').hide();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('getprediction') }}',
                    success: function(datas) {
                        $('#loadpred').hide();
                        $.each(datas, function(method, methodvalue) {
                            if (method == 'itemBased') {
                                $.each(methodvalue, function(index, dataB) {
                                    tablebookpred = $('#predTableBook')
                                        .DataTable();
                                    tablebookpred.row.add([dataB['member_id'],
                                        dataB['book_id'], dataB[
                                            'prediction']
                                    ]).draw().node();
                                })
                            } else if (method == 'userBased') {
                                $.each(methodvalue, function(index, dataB) {
                                    tablememberpred = $('#predTableMember')
                                        .DataTable();
                                    tablememberpred.row.add([dataB['member_id'],
                                        dataB['book_id'], dataB[
                                            'prediction']
                                    ]).draw().node();
                                })
                            }
                        })
                    }
                })
                .done(function(response){
                    $('#prediction').show();
                    $('#btnMae').show();
                })
            })
        })
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
