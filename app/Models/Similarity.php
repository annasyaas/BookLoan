<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Similarity extends Model
{
    public $timestamps = true;
    protected $table = 'similarities';
    protected $fillable = [
        'book_1',
        'book_2',
        'member_1',
        'member_2',
        'method',
        'value'
    ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    } 
    
    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }
}
