@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/loading.css') }}">
@endpush
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Halaman Perbandingan Akurasi</h1>
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
            <div class="row justify-content-center mt-5">
                <div class="col-lg-4 text-center">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="getMaeMape(0.15)">MAE Pengosongan Rating 15%</a>
                </div>
                <div class="col-lg-4 text-center">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="getMaeMape(0.3)">MAE Pengosongan Rating 30%</a>
                </div>
                <div class="col-lg-4 text-center">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="getMaeMape(0.45)">MAE Pengosongan Rating 45%</a>
                </div>
            </div>
            <div class="lds-roller ml-auto mr-auto mt-5" id="loadBtn">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="row text-center" style="margin-top: 100px" id="tableValue">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 id="judul"></h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <h4 class="mb-3 mt-5">Data Peminjaman Yang Dikosongkan</h4>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped" id="emptyTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <td>ID Anggota</td>
                                            <td>ID Buku</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="mb-3 mt-5">Prediksi Item-Based</h4>
                            <div class="table-responsive">
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
                            <div class="row mt-5">
                                <div class="col-lg-12">
                                    <h5 id="itemmae" class="text-primary"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="mb-3 mt-5">Prediksi User-Based</h4>
                            <div class="table-responsive">
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
                            <div class="row mt-5">
                                <div class="col-lg-12">
                                    <h5 id="usermae" class="text-primary"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5 mb-5">
                        <div class="col-lg-6">
                            <div class="alert alert-primary" role="alert">
                                <h4 class="alert-heading text-center">Kesimpulan</h4>
                                <p id="bestMae" class="text-center" style="font-size: 16px"></p>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#loadBtn').hide();
        $('#tableValue').hide();

        function getMaeMape(rate)
        {
            tableempty = $('#emptyTable').DataTable();
            tablebookpred = $('#predTableBook').DataTable();
            tablememberpred = $('#predTableMember').DataTable();
            tableempty.clear().draw();
            tablebookpred.clear().draw();
            tablememberpred.clear().draw();
            $('#loadBtn').show();
            $('#tableValue').hide();
            $.ajax({
                type: 'GET',
                url: '/recommendation/getMatrix/' + rate,
                success: function(data) {
                    $('#judul').text('Pengosongan Rating '+ rate * 100 +'%');
                    $.each(data, function(title, datas){
                        if (title == 'cleaned_loan') {
                            $.each(datas, function(index, dataB) {
                                tableempty.row.add([
                                    dataB['member_id'],
                                    dataB['book_id']
                                ]).draw().node();
                            })
                        } else if (title == 'itemPred') {
                            $.each(datas, function(index, dataB) {
                                tablebookpred.row.add([
                                    dataB['member_id'],
                                    dataB['book_id'], 
                                    dataB['prediction']
                                ]).draw().node();
                            })
                        } else if (title == 'userPred') {
                            $.each(datas, function(index, dataB) {
                                tablememberpred.row.add([
                                    dataB['member_id'],
                                    dataB['book_id'], 
                                    dataB['prediction']
                                ]).draw().node();
                            })
                        } 
                        $('#itemmae').text('Nilai MAE Item-Based : '+ data['itemMae']);
                        $('#usermae').text('Nilai MAE User-Based : '+ data['userMae']);
                        if(data['itemMae'] < data['userMae']) {
                            $('#bestMae').text('Metode Item-Based Collaborative Filtering memiliki akurasi yang lebih baik di pengosongan rating '+ rate * 100 +'%');
                        } else if(data['itemMae'] > data['userMae']) {
                            $('#bestMae').text('Metode User-Based Collaborative Filtering memiliki akurasi yang lebih baik di pengosongan rating '+ rate * 100 +'%');
                        }
                    })
                }
            })
            .done(function(response) {
                $('#loadBtn').hide();
                $('#tableValue').show();
            })
        }
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
