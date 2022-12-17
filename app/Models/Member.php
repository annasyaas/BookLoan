<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $timestamps = true;
    protected $table = 'members';
    protected $fillable = [
        'member_id',
        'name'
    ];
}
