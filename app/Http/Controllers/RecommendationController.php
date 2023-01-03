<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Recommendation;
use App\Http\Controllers\SimilarityController;
use App\Models\Loan;
use App\Models\Similarity;
use Illuminate\Http\Request;

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
        $books = Loan::select('book_id')->distinct()->get();
        $dataMatrix = $sim->matrix($id);

        if($member->loans->count() >= 3){
             
            return view('dashboard.recommendation.show', [
                'dataMatrix' => $dataMatrix,
                'books' => $books
            ]);
        }else{
            dd('kurang dari 3 peminjaman');
        }

    }
}
