@extends('dashboard.layouts.main')

@section('container')
    <section class="section">
        <div class="section-header text-center">
            <h4 class="text-primary"><i>COMPARISON OF THE ACCURACY OF COLLABORATIVE FILTERING METHODS 
                BASED ON ITEMS AND USERS  ON BOOK BORROWING SYSTEM</i></h4>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Member</h4>
                        </div>
                        <div class="card-body">
                            {{ $members }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Book</h4>
                        </div>
                        <div class="card-body">
                            {{ $books }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Book Borrowing</h4>
                        </div>
                        <div class="card-body">
                            {{ $loans }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card mt-sm-5 mt-md-0">
                    <div class="card-header">
                        <h4 style="font-size: 25px">System Description</h4>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 18px">Sistem ini merupakan Sistem Rekomendasi yang bertujuan untuk mengetahui perbandingan akurasi dari metode <i>Item-Based Collaborative Filtering</i>
                        dengan <i>User-Based Collaborative Filtering</i> pada studi kasus peminjaman buku di UPT. Perpustakaan Universitas Mulawarman. <br>
                        Data peminjaman yang digunakan merupakan data transaksi peminjaman dari <i>database</i> UPT. Peprustakan Universitas Mulawarman di bulan November 2019. <br>
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
