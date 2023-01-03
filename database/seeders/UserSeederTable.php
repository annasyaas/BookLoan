<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $datas = [[
            'id' => 1,
            'username' => 'annasya',
            'password' => bcrypt('12345'),
            'member' => 1,
            'is_admin' => 1
        ],[
            'id' => 2,
            'username' => 'aliffia',
            'password' => bcrypt('12345'),
            'member' => 2,
            'is_admin' => 0
        ],[
            'id' => 3,
            'username' => 'gandhi',
            'password' => bcrypt('12345'),
            'member' => 3,
            'is_admin' => 0
        ]];

        DB::table('users')->insert($datas);
    }
}
