@extends('dashboard.layouts.main')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/loading.css') }}">
@endpush
@section('container')
<div class="section">
    <div class="section-header">
        <h1>Comparison Page</h1>
    </div>
    <div class="section-body">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-2 text-center">
                <a href="javascript:void(0)" class="btn btn-primary" id="empty10">Lihat Pengosongan Rating 10%</a>
            </div>
        </div>
        <div class="lds-roller ml-auto mr-auto mt-5" id="load10">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="row" id="table10">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Matrix Pengosongan Rating 10%</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="mb-3 mt-5">Item-Based Prediction</h4>
                        <div class="table-responsive text-center">
                            <table class="table table-sm table-striped" id="predTableBook10" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>ID Member</td>
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
                        <h4 class="mb-3 mt-5">User-Based Prediction</h4>
                        <div class="table-responsive text-center">
                            <table class="table table-sm table-striped" id="predTableMember10" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>ID Member</td>
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
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-2 text-center">
                <a href="javascript:void(0)" class="btn btn-primary" id="empty20">Lihat Pengosongan Rating 20%</a>
            </div>
        </div>
        <div class="lds-roller ml-auto mr-auto mt-5" id="load20">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="row" id="table20">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Matrix Pengosongan Rating 20%</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="mb-3 mt-5">Item-Based Prediction</h4>
                        <div class="table-responsive text-center">
                            <table class="table table-sm table-striped" id="predTableBook20" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>ID Member</td>
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
                        <h4 class="mb-3 mt-5">User-Based Prediction</h4>
                        <div class="table-responsive text-center">
                            <table class="table table-sm table-striped" id="predTableMember20" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>ID Member</td>
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
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-2 text-center">
                <a href="javascript:void(0)" class="btn btn-primary" id="empty30">Lihat Pengosongan Rating 30%</a>
            </div>
        </div>
        <div class="lds-roller ml-auto mr-auto mt-5" id="load30">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="row" id="table30">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Matrix Pengosongan Rating 30%</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="mb-3 mt-5">Item-Based Prediction</h4>
                        <div class="table-responsive text-center">
                            <table class="table table-sm table-striped" id="predTableBook30" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>ID Member</td>
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
                        <h4 class="mb-3 mt-5">User-Based Prediction</h4>
                        <div class="table-responsive text-center">
                            <table class="table table-sm table-striped" id="predTableMember30" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>ID Member</td>
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
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $('#load10').hide();
        $('#load20').hide();
        $('#load30').hide();
        $('#empty20').hide();
        $('#empty30').hide();
        $('#table10').hide();
        $('#table20').hide();
        $('#table30').hide();
        $(document).ready(function(){

            $('#empty10').click(function(){
                $('#load10').show();
                $.ajax({
                    type: 'GET',
                    url: '/recommendation/getMatrix/' + 0.1,
                    success: function($data) {
                        
                    }
                })
                .done(function(response){
                    $('#load10').hide();
                    $('#table10').show();
                    $('#empty20').show();
                })
            })
            $('#empty20').click(function(){
                $('#load20').show();
                $.ajax({
                    type: 'GET',
                    url: '/recommendation/getMatrix/' + 0.2,
                    success: function($data) {
                        
                    }
                })
                .done(function(response){
                    $('#load20').hide();
                    $('#table20').show();
                    $('#empty30').show();
                })
            })
            $('#empty30').click(function(){
                $('#load30').show();
                $.ajax({
                    type: 'GET',
                    url: '/recommendation/getMatrix/' + 0.3,
                    success: function($data) {
                        
                    }
                })
                .done(function(response){
                    $('#load30').hide();
                    $('#table30').show();
                })
            })
        })
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
@endpush