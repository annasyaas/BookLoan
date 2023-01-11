@extends('dashboard.layouts.main')
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Recommendation Member Page</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Item-Based Prediction</h4>
                    <div class="table-responsive col-lg-12 mt-5">
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr>
                                    @foreach ($items as $item)
                                        <td>{{ $item->book->title }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h4>User-Based Prediction</h4>
                    <div class="table-responsive col-lg-12 mt-5">
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr>
                                    @foreach ($users as $user)
                                        <td>{{ $user->book->title }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
