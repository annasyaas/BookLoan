<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;

class SimilarityController extends Controller
{
    public function matrix(){
        $members = Loan::select('member_id')->distinct()->get();
        $loans = Loan::orderBy('book_id', 'asc')->get();
        $matrix = [];

        // pusingnya bukan main woy demi rumus ini :), i've tried diff ways TT
        foreach ($members as $member) {
            foreach ($loans as $loan) {
                if($loan->member_id == $member->member_id){
                    $val = 1;
                } else {
                    $val = 0;
                }
                // cek di peminjaman apakah id member dan id buku di variabel matrix masih kosong 
                if(empty($matrix[$member->member_id][$loan->book_id])){
                    $matrix[$member->member_id][$loan->book_id] = $val;
                }
            }
        }
        return $matrix;
    }

    public function bookSim(){
        $dataMatrix = $this->matrix();
        $books = Book::all();
        $members = Loan::select('member_id')->distinct()->get();
        $suitBooks = [];
        $sim = [];
        $sum = 0;
        
        // hitung total masing-masing buku telah dipinjam
        foreach ($books as $book) {
            $sumBook[$book->id] = Loan::where('book_id', $book->id)->get()->count();
        }

        // hitung total peminjaman antar buku pada member yang sama
        foreach ($books as $key => $book) {
            for($i = $key+1; $i < count($books); $i++){
                foreach ($members as $keys => $member) {
                    $memberID = $member->member_id;
                    if($dataMatrix[$memberID][$book->id] == 1 && $dataMatrix[$memberID][$books[$i]->id] == 1){
                        $suitBooks[$book->id][$books[$i]->id] = ++ $sum;
                    }
                }
                $sum = 0;
            }
        }

        // hitung similarity antar buku
        foreach ($suitBooks as $book_id => $oppo_books) {
            foreach ($oppo_books as $oppo_id => $value) {
                $sim[$book_id][$oppo_id] = round($value / (sqrt($sumBook[$book_id]) * sqrt($sumBook[$oppo_id])), 3);
            }
        }

        return $sim;
    }

    public function memberSim(){
        $dataMatrix = $this->matrix();
        $books = Book::all();
        $members = Loan::select('member_id')->distinct()->get();
        $suitBooks = [];
        $sim = [];
        $sum = 0;
        
        // hitung total masing-masing buku telah dipinjam
        foreach ($books as $book) {
            $sumBook[$book->id] = Loan::where('book_id', $book->id)->get()->count();
        }

        // hitung total peminjaman antar buku
        foreach ($books as $key => $book) {
            for($i = $key+1; $i < count($books); $i++){
                foreach ($members as $keys => $member) {
                    $memberID = $member->member_id;
                    if($dataMatrix[$memberID][$book->id] == 1 && $dataMatrix[$memberID][$books[$i]->id] == 1){
                        $suitBooks[$book->id][$books[$i]->id] = ++ $sum;
                    }
                }
                $sum = 0;
            }
        }

        // hitung similarity antar buku
        foreach ($suitBooks as $book_id => $oppo_books) {
            foreach ($oppo_books as $oppo_id => $value) {
                $sim[$book_id][$oppo_id] = round($value / (sqrt($sumBook[$book_id]) * sqrt($sumBook[$oppo_id])), 3);
            }
        }

        return $sim;
    }
}
