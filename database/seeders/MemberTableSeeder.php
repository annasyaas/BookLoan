<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTableSeeder extends Seeder
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
            'member_id' => '1615015166',
            'name' => 'Annasya Sintha Ambira' 
        ],[
            'id' => 2,
            'member_id' => '1615015169',
            'name' => 'Aliifia Rosita' 
        ],[
            'id' => 3,
            'member_id' => '1615015184',
            'name' => 'Gandhi Dwi Laksono' 
        ],[
            'id' => 4,
            'member_id' => '1615015189',
            'name' => 'anas misbahuddin' 
        ],[
            'id' => 5,
            'member_id' => '1615015191',
            'name' => 'abdul rahim' 
        ]];

        DB::table('members')->insert($datas);
    }
}
