<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SimilarityController;

class MaeMapeController extends Controller
{
    public function getMaeMape()
    {
        $this->matrix(0.45);
        return view('dashboard.maemape.show');
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
        $itemPred = $prediction['itemPrediction'];
        $userPred = $prediction['userPrediction'];
        $sum_item_mae = 0;
        $sum_user_mae = 0;
        // $sum_item_mape = 0;
        // $sum_user_mape = 0;

        foreach ($itemPred as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                $error_item[] = [
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'value' => $value,
                    'value_mae' => abs($value - 1),
                    // 'value_mape' => (abs($value - 1)) / $value
                ];
                $temp_mae = abs($value - 1);
                // $temp_mape = (abs($value - 1)) / $value;
                $sum_item_mae = $sum_item_mae + $temp_mae;
                // $sum_item_mape = $sum_item_mape + $temp_mape;
            }
        }
        foreach ($userPred as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                $error_user[] = [
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'value' => $value,
                    'value_mae' => abs($value - 1),
                    // 'value_mape' => (abs($value - 1)) / $value
                ];
                $temp_mae = abs($value - 1);
                // $temp_mape = (abs($value - 1)) / $value;
                $sum_user_mae = $sum_user_mae + $temp_mae;
                // $sum_user_mape = $sum_user_mape + $temp_mape;
            }
        }
        // Perhitungan nilai MAE 
        $mae_item = $sum_item_mae / count($error_item);
        $mae_user = $sum_user_mae / count($error_user);
        // $mape_item = ($sum_item_mape * 100) / count($error_item);
        // $mape_user = ($sum_user_mape * 100) / count($error_user);
        dd($mae_item);
        
        return response()->json([
            'itemPred' => $itemPred,
            'userPred' => $userPred,
            'itemError' => $error_item,
            'userError' => $error_user,
            'itemMae' => $mae_item,
            'userMae' => $mae_user,
            // 'itemMape' => $mape_item,
            // 'userMape' => $mape_user
        ], 200);
    }
}
