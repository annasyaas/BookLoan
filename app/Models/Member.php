<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $timestamps = true;
    protected $table = 'members';
    protected $fillable = [
        'member_id',
        'name',
        'institution'
    ];

    public function user(){
        return $this->hasOne(User::class, 'member_id');
    }

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
