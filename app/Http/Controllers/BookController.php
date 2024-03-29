<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // public function __construct()
    // {
    //     $this->model = Book::orderBy('id', 'ASC')->get();
    // }

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
    public function show($id)
    {
        $book = Book::where('id', $id)->first();
        
        return view('dashboard.books.show', [
            'book' => $book
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::where('id', $id)->first();

        return view('dashboard.books.edit', [
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        // Validasi request melalui form request buatan
        $item = $request->validated();
        
        // Update data yang telah lolos validasi
        Book::where('id', $book->id)->update($item);

        return redirect()->route('book.index')->with('success', 'Data Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function deleteData(Request $request)
    {
        Book::destroy($request['id']);

        return response()->json('berhasil', 200);
    }
    
    public function datas(){

        $datas = Book::orderBy('id', 'ASC')->get();;
        $i = 1;
        foreach($datas as $data) {
            $data['number'] = $i++;
        }
       return response()->json($datas, 200);
    }
}