<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $members = count(Member::all());
        $books = count(Book::all());
        $loans = count(Loan::all());

        return view('dashboard.index', [
            'members' => $members,
            'books' => $books,
            'loans' => $loans
        ]);
    }
}
