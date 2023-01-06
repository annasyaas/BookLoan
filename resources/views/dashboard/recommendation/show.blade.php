@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Recommendation Page</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mb-3 ">Matrix</h4>
                    <div class="table-responsive">
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
                    <a href="javascript:void(0)" class="btn btn-primary" id="simBtn">Lihat Similarity Buku</a>
                </div>
            </div>
            <div class="row" id="similarity">
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Book Similarity</h4>
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
                    <h4 class="mb-3 mt-5">Member Similarity</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="simTableMember" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Member ke-1</td>
                                    <td>ID Member ke-2</td>
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
            <div class="row" id="prediction">
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Item-Based Prediction</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="predTableBook" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Member</td>
                                    <td>ID Buku</td>
                                    <td>Nilai Prediksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prediction['itemBased'] as $member_id => $books)
                                    @foreach ($books as $book_id => $valPrediction)
                                        <tr>
                                            <td>{{ $member_id }}</td>
                                            <td>{{ $book_id }}</td>
                                            <td>{{ $valPrediction}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">User-Based Prediction</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="predTableMember" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Member</td>
                                    <td>ID Buku</td>
                                    <td>Nilai Prediksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prediction['userBased'] as $member_id => $books)
                                    @foreach ($books as $book_id => $valPrediction)
                                        <tr>
                                            <td>{{ $member_id }}</td>
                                            <td>{{ $book_id }}</td>
                                            <td>{{ $valPrediction}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            tablebookpred = $('#predTableBook').DataTable();
            tablememberpred = $('#predTableMember').DataTable();
            $('#similarity').hide();
            $('#prediction').hide();
            
            $('#simBtn').click(function(){
                $.ajax({
                    type: 'GET',
                    url: '{{ route("getbook") }}',
                    success: function(dataB){
                        $.each(dataB, function(book_1,books){
                            $.each(books, function(book_2, value){
                                tablebooksim = $('#simTableBook').DataTable();
                                tablebooksim.row.add([book_1, book_2, value]).draw().node();
                            })
                        })
                    }
                })
                $.ajax({
                    type: 'GET',
                    url: '{{ route("getmember") }}',
                    success: function(dataM){
                        $.each(dataM, function(member_1,members){
                            $.each(members, function(member_2, value){
                                tablemembersim = $('#simTableMember').DataTable();
                                tablemembersim.row.add([member_1, member_2, value]).draw().node();
                            })
                        })
                    $('#similarity').show();
                    }
                })
            $(this).hide();
            })

            $('#predBtn').click(function(){
                $.ajax({
                    type: 'GET',
                    url: '{{ route("getbook") }}',
                    success: function(dataB){
                        $.each(dataB, function(book_1,books){
                            $.each(books, function(book_2, value){
                                tablebooksim = $('#simTableBook').DataTable();
                                tablebooksim.row.add([book_1, book_2, value]).draw().node();
                            })
                        })
                    }
                })
                $.ajax({
                    type: 'GET',
                    url: '{{ route("getmember") }}',
                    success: function(dataM){
                        $.each(dataM, function(member_1,members){
                            $.each(members, function(member_2, value){
                                tablemembersim = $('#simTableMember').DataTable();
                                tablemembersim.row.add([member_1, member_2, value]).draw().node();
                            })
                        })
                    $('#similarity').show();
                    }
                })
            $(this).hide();
            })
        })
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
