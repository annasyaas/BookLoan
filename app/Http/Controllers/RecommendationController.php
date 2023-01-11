<?php

namespace App\Http\Controllers;

use App\Models\Similarity;
use App\Models\Recommendation;
use App\Http\Controllers\SimilarityController;

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
        set_time_limit(3600);
        $sim = new SimilarityController;
        $dataMatrix = $sim->matrix();

        return view('dashboard.recommendation.show', [
            'dataMatrix' => $dataMatrix
        ]);
    }

    public function prediction()
    {
        try{
        set_time_limit(3600);
        $sim = new SimilarityController;
        $matrix = $sim->matrix();
        $bookSims = Similarity::select('book_1', 'book_2', 'value')->where('method', 1)->get();
        $memberSims = Similarity::select('member_1', 'member_2', 'value')->where('method', 0)->get();
        
        /************************************************** ITEM-BASED  ***************************************************/
        // ambil data matrix yang bernilai 1 (meminjam)
        foreach ($matrix as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                if($value == 1){
                    $matrix_1[$member_id][] = $book_id;
                }
            }
        }
        // cari tetangga terdekat yang bernilai 1 di member yang sama
        foreach($matrix as $member_id => $books) {
            foreach($books as $book_id => $value) {
                if($value == 0){
                    foreach ($bookSims as $bookSim) {
                        $book_1 = $bookSim->book_1;
                        $book_2 = $bookSim->book_2;
                        foreach ($matrix_1[$member_id] as $book_id_2) {
                            if($book_1 == $book_id && $book_2 == $book_id_2){
                                $suitBooks[$member_id][$book_1][$book_2] = $bookSim->value;
                            } elseif($book_1 == $book_id_2 && $book_2 == $book_id) {
                                $suitBooks[$member_id][$book_2][$book_1] = $bookSim->value;
                            }
                        }
                    }
                }
            }
        }
        // cari nilai tertinggi dari item tetangga yang dicocokkan 
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
            $topPredictionItem[$member_id] = array_slice($predValue, 0, 5, true);
        }
        
        /************************************************* USER-BASED  *********************************************************/
        
        // mencari prediksi USER-BASED, dengan mencari nilai kemiripan tertinggi dari user tetangga terdekat
        foreach ($matrix as $member_id => $books) {
            foreach ($books as $book_id => $value) {
                if($value == 1){
                    $matrixUser[$book_id][] = $member_id;
                }
            }
        }
        foreach ($matrix as $member_id => $books){
            foreach ($books as $book_id => $value) {
                if($value == 0) {
                    foreach ($memberSims as $memberSim){
                        $member_1 = $memberSim->member_1;
                        $member_2 = $memberSim->member_2;
                        // mencari nilai tertinggi kecuali item user kosong
                        foreach ($matrixUser[$book_id] as $matrix_user) {
                            if($member_1 == $member_id && $member_2 == $matrix_user){
                                $suitMembers[$member_id][$book_id][$member_2] = $memberSim->value;
                            }elseif($member_2 == $member_id && $member_1 == $matrix_user){
                                $suitMembers[$member_id][$book_id][$member_1] = $memberSim->value;
                            }
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
            arsort($predValue);
            $topPredictionUser[$member_id] = array_slice($predValue, 0, 5, true);
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
        }catch(\Exception $error){
            dd($error);
        }
    }

    public function savePrediction($prediction, $int)
    {
        foreach ($prediction as $member_id => $books_) {
            foreach ($books_ as $book_id => $pred) {
                Recommendation::updateOrCreate([
                    'member_id' => $member_id,
                    'book_id' => $book_id,
                    'prediction' => $pred,
                    'method' => $int
                ]);
            }
        }

        return true;
    }
}
