@extends('dashboard.layouts.main')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Buku Yang Mungkin Member Sukai</h1>
        </div>
        <div class="section-body mt-3">
            <div class="row mb-5">
                <div class="col-lg-12">
                    {{-- <h4 class="text-center">Item-Based Prediction</h4> --}}
                    <div class="table-responsive col-lg-12 mt-5">
                        <table class="table table-bordered table-md" id="dataTable">
                            <thead>
                                <th scope="col" width="8%">No</th>
                                <th scope="col" width="12%">Nomor Panggil</th>
                                <th scope="col" width="30%">Judul</th>
                                <th scope="col" width="8%">Salin</th>
                                <th scope="col" width="15%">Penerbit</th>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->book->call_number }}</td>
                                    <td>{{ $item->book->title }}</td>
                                    <td>{{ $item->book->copy }}</td>
                                    <td>{{ $item->book->publisher }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-12">
                    <h4 class="text-center">User-Based Prediction</h4>
                    <div class="table-responsive col-lg-12 mt-5">
                        <table class="table table-bordered table-md" id="dataTable">
                            <thead>
                                <th scope="col" width="8%">No</th>
                                <th scope="col" width="12%">Nomor Panggil</th>
                                <th scope="col" width="30%">Judul</th>
                                <th scope="col" width="8%">Salin</th>
                                <th scope="col" width="15%">Penerbit</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->book->call_number }}</td>
                                    <td>{{ $user->book->title }}</td>
                                    <td>{{ $user->book->copy }}</td>
                                    <td>{{ $user->book->publisher }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
            <div class="row text-center mt-4">
                <div class="col-lg-12">
                    <a href="{{ route('member.index') }}" class="btn btn-success text-decoration-none mr-2">
                        <span data-feather="arrow-left"></span> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('#dataTable').DataTable({sDom: t});
    })
</script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
