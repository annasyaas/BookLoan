<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public $timestamps = true;
    protected $table = 'loans';
    protected $fillable = [
        'book_id',
        'member_id',
        'copy_code',
        'loan_date',
        'date_returned',
        'status'
    ];
}
