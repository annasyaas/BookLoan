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
        $datas = [
            'id' => 1,
            'username' => 'admin',
            'password' => bcrypt('12345'),
        ];

        DB::table('users')->insert($datas);
    }
}
