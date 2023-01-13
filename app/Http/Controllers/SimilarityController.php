<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Similarity;
use Illuminate\Support\Facades\DB;

class SimilarityController extends Controller
{
    protected $dataMatrix;

    public function __construct()
    {
        $this->dataMatrix = $this->matrix();
    }

    public function matrix(){
        // ambil member yang telah meminjam lebih dari sama dengan 3
        $members = Loan::select('member_id')->whereIn('member_id', function($query){
            $query->select('member_id')->from('loans')
            ->groupBy('member_id')
            ->having(DB::raw('count(*)'), '>=', '5')->get();
        })->distinct()->get();
        $member_id = $members->pluck('member_id')->toArray();
        $loans = Loan::whereIn('member_id', $member_id)->orderBy('book_id', 'asc')->get();
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

    // Menghitung similarity
    public function similarity($dataMatrix){
        set_time_limit(3600);
        foreach ($dataMatrix as $member_id => $book) {
            $members[] = $member_id;
        }
        foreach (array_values($dataMatrix)[0] as $book_id => $value) {
            $books[] = $book_id;
        }
        $suitBooks = [];
        $suitMembers = [];
        $sim_book = [];
        $sim_member = [];
        $sum_book = count($books);
        $sum_member = count($members);
        
        /*********************************************  ITEM-BASED  **************************************************/
        // hitung total masing-masing buku telah dipinjam
        foreach ($books as $book) {
            $sumBook[$book] = Loan::where('book_id', $book)->get()->count();
        }
        // hitung total peminjaman antar buku pada member yang sama
        foreach ($books as $key => $book) { // buku pertama
            for($i = $key+1; $i < $sum_book; $i++){ // buku kedua / pembanding
                $sumu = 0;
                foreach ($members as $member) {
                    if($dataMatrix[$member][$book] == 1 && $dataMatrix[$member][$books[$i]] == 1){
                        $suitBooks[$book][$books[$i]] = ++$sumu;
                    } 
                }
            }
        }
        // hitung similarity antar buku dan simpan kedalam database
        foreach ($suitBooks as $book_1 => $oppo_books) {
            foreach ($oppo_books as $book_2 => $value) {
                $value_book = round($value / (sqrt($sumBook[$book_1]) * sqrt($sumBook[$book_2])), 3);
                $sim_book[$book_1][$book_2] = $value_book;
            }
        }

        /*********************************************  USER-BASED  **************************************************/
        
        // hitung total masing-masing member telah meminjam
        foreach ($members as $member) {
            $sumMember[$member] = Loan::where('member_id', $member)->get()->count();
        }

        // hitung total peminjaman buku antar member dengan buku yang sama
        foreach ($members as $key => $member) {
            for($i = $key+1; $i < $sum_member; $i++){
                $sum = 0;
                foreach ($books as $book) {
                    if($dataMatrix[$member][$book] == 1 && $dataMatrix[$members[$i]][$book] == 1){
                        $suitMembers[$member][$members[$i]] = ++$sum;
                    }
                }
            }
        }
        // hitung similarity antar member
        foreach ($suitMembers as $member_1 => $oppo_members) {
            foreach ($oppo_members as $member_2 => $value) {
                $value_member = round($value / (sqrt($sumMember[$member_1]) * sqrt($sumMember[$member_2])), 3);
                $sim_member[$member_1][$member_2] = $value_member;
            }
        }
        
        return [
            'itemSim' => $sim_book,
            'memberSim' => $sim_member
        ];
    }

    public function getSimilarity()
    {
        $matrix = $this->dataMatrix;
        $datas = $this->similarity($matrix);

        foreach ($datas['itemSim'] as $book_1 => $books) {
            foreach ($books as $book_2 => $value_book) {
                Similarity::updateOrCreate([
                    'book_1' => $book_1,
                    'book_2' => $book_2,
                    'value' => $value_book,
                    'method' => 1 // 1 for item-based
                ]);
            }
        }
        foreach ($datas['memberSim'] as $member_1 => $members) {
            foreach ($members as $member_2 => $value_member) {
                Similarity::updateOrCreate([
                    'member_1' => $member_1,
                    'member_2' => $member_2,
                    'value' => $value_member,
                    'method' => 0 // 0 for user-based
                ]);
            }
        }
        return response()->json($datas, 200);
    }
}
