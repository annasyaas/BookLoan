<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::with('member', 'book')->get();
    
        return view('dashboard.loans.index', [
            'loans' => $loans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::where('copy', '>', 0)->get();

        return view('dashboard.loans.create', [
            'members' => $members,
            'books' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanRequest $request)
    {
        $datas = $request->validated();
        
        // mengurangi copy buku
        $book = Book::find($datas['book_id']);
        $book->copy = $book->copy - 1;
        $book->save();       

        $datas['status'] = 0;

        Loan::create($datas);

        return redirect()->route('loan.index')->with('success', 'Data Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $members = Member::all();
        $books = Book::all();
        
        return view('dashboard.loans.edit', [
            'loan' => $loan,
            'members' => $members,
            'books' => $books
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(LoanRequest $request, Loan $loan)
    {
        $item = $request->validated();

        $loan->update($item);
        $loan->save();

        return redirect()->route('loan.index')->with('success', 'Data Peminjaman berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        if($loan->delete()){
            return response()->json('berhasil', 200);
        }else{
            return response()->json('gagal', 500);
        }
    }

    public function copy($id)
    {
        $copy = Book::where('id', $id)->pluck('copy');
        
        return response()->json($copy, 200);
    }

    public function updateCopy(Request $request)
    {
        $book = Book::find($request['book']);
        $loan = Loan::find($request['id']);

        //update status peminjaman sesuai request 
        $loan->status = $request['copy'];
        
        //cek apakah peminjaman buku (0), pengembalian buku (1)
        if($request['copy'] == 1) {
            $book->copy = $book->copy + 1; //jika pengembalian, maka jumlah copy buku ditambah 1
        } else {
            $book->copy = $book->copy - 1; //jika peminjaman, maka jumlah copy buku dikurangi 1
        }

        if($book->save() && $loan->save()){
            return response()->json('success', 200);
        } else {
            return response()->json('failed', 400);
        }
    }
}
