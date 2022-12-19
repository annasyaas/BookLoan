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
        'name'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
