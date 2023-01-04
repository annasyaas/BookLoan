<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Similarity;
use Illuminate\Http\Request;

class SimilarityController extends Controller
{
    public function matrix(){
        $members = Loan::select('member_id')->distinct()->get();
        $loans = Loan::all();
        $matrix = [];

        // pusingnya bukan main woy demi rumus ini :), berbagai cara ku coba TT
        foreach ($members as $member) {
            foreach ($loans as $loan) {
                if($loan->member_id == $member->member_id){
                    $val = 1;
                } else {
                    $val = 0;
                }
                // cek di peminjaman apakah id member dan id buku masih kosong 
                if(empty($matrix[$member->member_id][$loan->book_id])){
                    $matrix[$member->member_id][$loan->book_id] = $val;
                }
            }
        }
        
        return $matrix;
    }

    public function calculation(){

    }
}
