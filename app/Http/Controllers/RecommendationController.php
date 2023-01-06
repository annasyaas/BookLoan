<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Controllers\SimilarityController;
use App\Models\Loan;
use App\Models\Similarity;

class RecommendationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function recommendation()
    {
        $sim = new SimilarityController;
        $dataMatrix = $sim->matrix();
        $bookSim = $sim->bookSim();
        $memberSim = $sim->memberSim();
        $prediction = $this->prediction($dataMatrix);

        return view('dashboard.recommendation.show', [
            'dataMatrix' => $dataMatrix,
            'bookSim' => $bookSim,
            'memberSim' => $memberSim,
            'prediction' => $prediction
        ]);
    }

    public function prediction($matrix)
    {
        $emptyRatings = $this->emptyRate($matrix);
        $bookSims = Similarity::select('book_1', 'book_2', 'value')->where('method', 1)->get();
        $memberSims = Similarity::select('member_1', 'member_2', 'value')->where('method', 0)->get();
        
        // mencari prediksi item-based, dengan mencari nilai kemiripan tertinggi dari item tetangga terdekat
        foreach ($emptyRatings as $member_id => $books){
            foreach ($books as $key => $book_id) {
                foreach ($bookSims as $bookSim){
                    $book_1 = $bookSim->book_1;
                    $book_2 = $bookSim->book_2;
                    foreach ($matrix[$member_id] as $matrix_book => $val) {
                        if($book_1 == $book_id && $book_2 == $matrix_book && $val == 1){
                            $suitBooks[$member_id][$book_1][$book_2] = $bookSim->value;
                        }elseif($book_2 == $book_id && $book_1 == $matrix_book && $val == 1){
                            $suitBooks[$member_id][$book_2][$book_1] = $bookSim->value;
                        }       
                        
                    }
                }
            }
        }
        foreach ($suitBooks as $member_id => $books) {
            foreach ($books as $book_1 => $oppo_books) {
                foreach ($oppo_books as $value) {
                    $valBook[$member_id][] = $value;
                }
                $predictionItem[$member_id][$book_1] = 1 * max($valBook[$member_id]); // rumus prediksi
            }
        }
        // sort prediksi ambil 5 teratas
        foreach ($predictionItem as $member_id => $predValue) {
            asort($predValue);
            $reverse = array_reverse($predValue, true);
            $sortPredictionItem[$member_id] = $reverse;
        }
        foreach ($sortPredictionItem as $member_id => $sortValue) {
            $topPrediction[$member_id] = array_slice($sortValue, 0, 5, true);
        }
        
        // mencari prediksi user-based, dengan mencari nilai kemiripan tertinggi dari user tetangga terdekat
        foreach ($emptyRatings as $member_id => $books){
            foreach ($books as $book_id) {
                foreach ($memberSims as $memberSim){
                    // dd($memberSim);
                    if($memberSim->member_1 == $member_id){
                        $suitMembers[$member_id][$book_id][$memberSim->member_2] = $memberSim->value;
                    }elseif($memberSim->member_2 == $member_id){
                        $suitMembers[$member_id][$book_id][$memberSim->member_1] = $memberSim->value;
                    }
                }
            }
        }
        dd($suitMembers);
        foreach ($suitBooks as $member_id => $books) {
            foreach ($books as $book_1 => $oppo_books) {
                foreach ($oppo_books as $value) {
                    $val[$member_id][] = $value;
                }
                $predictionItem[$member_id][$book_1] = 1 * max($val[$member_id]);
            }
        }
    }
    
    // mencari rating kosong dari tiap member
    public function emptyRate($matrix) 
    {
        $members = Loan::select('member_id')->distinct()->pluck('member_id');

        foreach ($members as $member) {
            $matrixMember = $matrix[$member];
            foreach ($matrixMember as $book_id => $value) {
                if($value == 0){
                    $emptyRatings[$member][] = $book_id;
                }
            }
        }

        return $emptyRatings;
    }
}
