@extends('dashboard.layouts.main')
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Recommendation Page</h1>
        </div>
        <div class="section-body">
        <h4 class="ml-3 mb-3">Matrix</h4>
            <div>
                <div class="table-responsive col-lg-12">
                    <table class="table table-sm text-center" style="width: 100%" border="2">
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
        <h4 class="ml-3 mb-3">Book Similarity</h4>
            <div>
                <div class="table-responsive col-lg-12">
                    <table class="table table-sm text-center" style="width: 100%" border="2">
                        
                    </table>
                </div>
            </div>
        </div>
        <h4 class="ml-3 mb-3">Member Similarity</h4>
            <div>
                
            </div>
        </div>
    </div>
@endsection
