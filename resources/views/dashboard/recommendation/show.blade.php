@extends('dashboard.layouts.main')
@section('container')
    <div class="section">
        {{-- {{ dd($dataMatrix) }} --}}
        <div class="section-header">
            <h1>Recommendation Page</h1>
        </div>
        <div class="section-body">
            <div>
                <div class="table-responsive col-lg-12">
                    <table class="table table-sm text-center" style="width: 100%" border="2">
                        <tr>
                            <td>#</td>
                            @foreach ($books as $book)
                                <td>{{ $book->book_id }}</td>
                            @endforeach
                        </tr>
                        @foreach (array_keys($dataMatrix) as $user)
                            <tr>
                                <td>{{ $user }}</td>
                                @foreach (array_keys($dataMatrix[$user]) as $book)
                                    <td>{{ $dataMatrix[$user][$book] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
