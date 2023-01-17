<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SimilarityController;

class MaeMapeController extends Controller
{
    public function getMaeMape()
    {
        $sim = new SimilarityController;

        return view('dashboard.maemape.show', [
            'dataMatrix' => $sim->matrix()
        ]);
    }
    
    public function matrix($rate)
    {
        $members = Loan::whereIn('member_id', function($query){
            $query->select('member_id')->from('loans')
            ->groupBy('member_id')
            ->having(DB::raw('count(*)'), '>=', '5')->get();
        })->get();
        $cleaned_rate = $members->random(count($members) * $rate); // random peminjaman yang akan di set nilai 0 pada matrix
        $sim = new SimilarityController;
        $rec = new RecommendationController;
        $matrix = $sim->matrix();
        $similarity = $sim->similarity($sim->matrix());

        // set nilai 0 pada matrix 
        foreach ($cleaned_rate as $loan) {
            foreach ($matrix[$loan->member_id] as $book_id => $value) {
                if($book_id == $loan->book_id) {
                    $matrix[$loan->member_id][$loan->book_id] = 0;
                }
            }
        }

        // set similarity sesuai matrix setelah pengosongan rating
        foreach ($similarity['itemSim'] as $book_1 => $books) {
            foreach ($books as $book_2 => $value) {
                $bookSims[] = [
                    'book_1' => $book_1,
                    'book_2' => $book_2,
                    'value' => $value
                ];
            }
        }
        foreach ($similarity['memberSim'] as $member_1 => $members) {
            foreach ($members as $member_2 => $value) {
                $memberSims[] = [
                    'member_1' => $member_1,
                    'member_2' => $member_2,
                    'value' => $value
                ];
            }
        }

        $prediction = $rec->prediction($matrix, $bookSims, $memberSims);
        $sum_item_mae = 0;
        $sum_user_mae = 0;

        foreach ($prediction['itemPrediction'] as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                $itemPred[] = [
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'prediction' => $value
                ];
                $temp_mae = abs($value - 1);
                $sum_item_mae = $sum_item_mae + $temp_mae;
            }
        }
        foreach ($prediction['userPrediction'] as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                $userPred[] = [
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'prediction' => $value
                ];
                $temp_mae = abs($value - 1);
                $sum_user_mae = $sum_user_mae + $temp_mae;
            }
        }
        // Perhitungan nilai MAE 
        $mae_item = $sum_item_mae / count($itemPred);
        $mae_user = $sum_user_mae / count($userPred);
        
        return [
            'cleaned_loan' => $cleaned_rate,
            'itemPred' => collect($itemPred),
            'userPred' => collect($userPred),
            'itemMae' => round($mae_item, 3),
            'userMae' => round($mae_user, 3)
        ];
    }
}
