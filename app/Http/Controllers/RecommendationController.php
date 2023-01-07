<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SimilarityController;
use App\Models\Loan;
use App\Models\Recommendation;
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
        
        return view('dashboard.recommendation.show', [
            'dataMatrix' => $dataMatrix
        ]);
    }

    public function prediction()
    {
        $sim = new SimilarityController;
        $matrix = $sim->matrix();
        $emptyRatings = $this->emptyRate($matrix);
        $bookSims = Similarity::select('book_1', 'book_2', 'value')->where('method', 1)->get();
        $memberSims = Similarity::select('member_1', 'member_2', 'value')->where('method', 0)->get();
        
        // mencari prediksi ITEM-BASED, dengan mencari nilai kemiripan tertinggi dari item tetangga terdekat
        foreach ($emptyRatings as $member_id => $books){
            foreach ($books as $book_id) {
                foreach ($bookSims as $bookSim){
                    $book_1 = $bookSim->book_1;
                    $book_2 = $bookSim->book_2;
                    // mencari nilai tertinggi kecuali item buku kosong
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
                    $valBook[$member_id][$book_1][] = $value;
                }
                $predictionItem[$member_id][$book_1] = 1 * max($valBook[$member_id][$book_1]); // rumus prediksi
            }
        }
        // sort prediksi ambil 5 teratas
        foreach ($predictionItem as $member_id => $predValue) {
            arsort($predValue);
            $sortPredictionItem[$member_id] = $predValue;
        }
        foreach ($sortPredictionItem as $member_id => $sortValue) {
            $topPredictionItem[$member_id] = array_slice($sortValue, 0, 5, true);
        }

        // mencari prediksi USER-BASED, dengan mencari nilai kemiripan tertinggi dari user tetangga terdekat
        foreach ($matrix as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                $matrixUser[$book_id][$member_id] = $value;
            }
        }
        foreach ($emptyRatings as $member_id => $books){
            foreach ($books as $book_id) {
                foreach ($memberSims as $memberSim){
                    $member_1 = $memberSim->member_1;
                    $member_2 = $memberSim->member_2;
                    // mencari nilai tertinggi kecuali item user kosong
                    foreach ($matrixUser[$book_id] as $matrix_user => $val) {
                        if($member_1 == $member_id && $member_2 == $matrix_user && $val == 1){
                            $suitMembers[$member_id][$book_id][$member_2] = $memberSim->value;
                        }elseif($member_2 == $member_id && $member_1 == $matrix_user && $val == 1){
                            $suitMembers[$member_id][$book_id][$member_1] = $memberSim->value;
                        }
                    }
                }
            }
        }
        foreach ($suitMembers as $member_id => $book) {
            foreach ($book as $book_1 => $oppo_book) {
                foreach ($oppo_book as $value) {
                    $valMember[$member_id][$book_1][] = $value;
                }
                $predictionUser[$member_id][$book_1] = 1 * max($valMember[$member_id][$book_1]);
            }
        }
        // sort prediksi ambil 5 teratas
        foreach ($predictionUser as $member_id => $predValue) {
            asort($predValue);
            $sortPredictionUser[$member_id] = $predValue;
        }
        foreach ($sortPredictionUser as $member_id => $sortValue) {
            $topPredictionUser[$member_id] = array_slice($sortValue, 0, 5, true);
        }

        // simpan nilai prediksi ke database
        $saveItem = $this->savePrediction($topPredictionItem, 1);
        $saveUser = $this->savePrediction($topPredictionUser, 0);
        
        if($saveItem && $saveUser){
            $datas = [
                'itemBased' => Recommendation::select('member_id', 'book_id', 'prediction')->where('method', 1)->get(),
                'userBased' => Recommendation::select('member_id', 'book_id', 'prediction')->where('method', 0)->get()
            ];

            return response()->json($datas, 200);
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

    public function savePrediction($prediction, $int)
    {
        foreach ($prediction as $member_id => $books_) {
            foreach ($books_ as $book_id => $pred) {
                $predictionDatas[] = [
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'prediction' => $pred,
                    'method' => $int
                ];
            }
        }
        foreach ($predictionDatas as $datas) {
            Recommendation::updateOrCreate($datas);
        }

        return true;
    }
}
