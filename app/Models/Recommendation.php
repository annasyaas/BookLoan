<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    public $timestamps = true;
    protected $table = 'recommendations';
    protected $fillable = [
        'member_id',
        'book_id',
        'method',
        'prediction'
    ];

    public function member(){
        return $this->belongsTo(User::class, 'member_id');
    }

    public function book(){
        return $this->belongsTo(Loan::class);
    }
}
