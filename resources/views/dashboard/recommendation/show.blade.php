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
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Book Similarity</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="dataTableBuku" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Buku ke-1</td>
                                    <td>ID Buku ke-2</td>
                                    <td>Nilai Similarity</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookSim as $book_id1 => $books)
                                    @foreach ($books as $book_id2 => $value)
                                        <tr>
                                            <td>{{ $book_id1 }}</td>
                                            <td>{{ $book_id2 }}</td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="mb-3 mt-5">Member Similarity</h4>
                    <div class="table-responsive text-center">
                        <table class="table table-sm table-striped" id="dataTableMember" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>ID Member ke-1</td>
                                    <td>ID Member ke-2</td>
                                    <td>Nilai Similarity</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memberSim as $member_id1 => $members)
                                    @foreach ($members as $member_id2 => $value)
                                        <tr>
                                            <td>{{ $member_id1 }}</td>
                                            <td>{{ $member_id2 }}</td>
                                            <td>{{ $value }}</td>
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
            $('#dataTableBuku').DataTable();
            $('#dataTableMember').DataTable();
        })
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
