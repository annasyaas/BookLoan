<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = true;
    protected $table = 'books';
    protected $fillable = [
        'call_number',
        'title',
        'copy',
        'publish_place',
        'publisher',
        'isbn_issn'
    ];

    public function loans(){
        return $this->hasMany(Loan::class);
    }

    public function recommendations(){
        return $this->hasMany(Recommendation::class);
    }

    public function similarities(){
        return $this->hasMany(Similarity::class);
    }
}
