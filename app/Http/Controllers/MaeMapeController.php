<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaeMapeController extends Controller
{
    public function getNilai()
    {
        return view('dashboard.maemape.show');
    }
}
