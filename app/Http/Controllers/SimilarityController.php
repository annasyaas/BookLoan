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
        $books = Book::all();
        $members = Member::all();
        $loans = Loan::all();
        $matrix = [];

        foreach ($books as $key => $book) {
            
        }

        foreach ($loans as $loan) {
            $user = $loan->member_id;
            $book = $loan->book_id;
            $rate = 1;

            $matrix[$user][$book] = $rate;
        }
        
        return $matrix;
    }
}
