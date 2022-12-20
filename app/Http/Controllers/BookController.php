<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->model = Book::orderBy('id', 'ASC')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.books.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $datas = $request->validated();

        Book::create($datas);

        return redirect('/book')->with('success', 'Data buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
    
    public function datas(){

        $datas = $this->model;

        foreach($datas as $data) {
            $data['action'] = "
            <a href='/book/". $data->id ."' class='btn btn-sm btn-info'>
                <i class='fa fa-eye'></i></a>
            <a href='/book/".$data->id ."/edit' class='btn btn-sm btn-warning'>
                <i class='fa fa-pencil-alt'></i></a>
            <form action='/book/". $data->id."' method='post' class='d-inline'>
                <button class='btn btn-sm btn-danger border-0' onclick='return confirm('Are you sure?')'>
                <i class='fa fa-trash'></i></button>
            </form>
            ";
        }
       return response()->json($datas, 200);
    }
}