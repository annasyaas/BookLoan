<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function __construct()
    {
        $this->table = 'users';
    }

    public function run()
    {
        User::create([
            'username' => 'annasya',
            'password' => bcrypt('12345')
        ]);
    }
}
