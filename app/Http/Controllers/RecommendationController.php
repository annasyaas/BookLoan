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
        $member = Member::with('loans')->find($id);
        $sim = new SimilarityController;
        $dataMatrix = $sim->matrix();
        dd($sim->bookSim());
        return view('dashboard.recommendation.show', [
            'dataMatrix' => $dataMatrix
        ]);
    }
}
