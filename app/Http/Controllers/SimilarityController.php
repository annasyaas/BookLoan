<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

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

    // Similarity antar item
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
                foreach ($members as $member) {
                    $memberID = $member->member_id;
                    if($dataMatrix[$memberID][$book->id] == 1 && $dataMatrix[$memberID][$books[$i]->id] == 1){
                        $suitBooks[$book->id][$books[$i]->id] = ++ $sum;
                    } 
                }
                $sum = 0;
            }
        }

        // hitung similarity antar buku
        foreach ($suitBooks as $book_1 => $oppo_books) {
            foreach ($oppo_books as $book_2 => $value) {
                $sim[$book_1][$book_2] = round($value / (sqrt($sumBook[$book_1]) * sqrt($sumBook[$book_2])), 3);
            }
        }

        return $sim;
    }

    // Similarity antar user
    public function memberSim(){
        $dataMatrix = $this->matrix();
        $members = Member::all();
        $books = Loan::select('book_id')->distinct()->get();
        $suitMembers = [];
        $sim = [];
        $sum = 0;
        
        // hitung total masing-masing member telah meminjam
        foreach ($members as $member) {
            $sumMember[$member->id] = Loan::where('member_id', $member->id)->get()->count();
        }

        // hitung total peminjaman buku antar member dengan buku yang sama
        foreach ($members as $key => $member) {
            for($i = $key+1; $i < count($members); $i++){
                foreach ($books as $book) {
                    $bookID = $book->book_id;
                    if($dataMatrix[$member->id][$bookID] == 1 && $dataMatrix[$members[$i]->id][$bookID] == 1){
                        $suitMembers[$member->id][$members[$i]->id] = ++ $sum;
                    }
                }
                $sum = 0;
            }
        }

        // hitung similarity antar member
        foreach ($suitMembers as $member_id => $oppo_members) {
            foreach ($oppo_members as $oppo_id => $value) {
                $sim[$member_id][$oppo_id] = round($value / (sqrt($sumMember[$member_id]) * sqrt($sumMember[$oppo_id])), 3);
            }
        }

        return $sim;
    }
}
