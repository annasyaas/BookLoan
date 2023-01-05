<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Controllers\SimilarityController;
use App\Models\Loan;

class RecommendationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recommendation  $recommendation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sim = new SimilarityController;
        $dataMatrix = $sim->matrix();
        $bookSim = $sim->bookSim();
        $memberSim = $sim->memberSim();
        $bookPred = $this->prediction();
        $memberPred = $this->prediction();

        return view('dashboard.recommendation.show', [
            'dataMatrix' => $dataMatrix,
            'bookSim' => $bookSim,
            'memberSim' => $memberSim,
            'bookPred' => $bookPred,
            'memberPred' => $memberPred
        ]);
    }

    public function prediction()
    {
        
    }
}
