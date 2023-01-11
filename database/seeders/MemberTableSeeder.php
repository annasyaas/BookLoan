<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = 'members';
        $this->filename = base_path().'/database/seeders/member_seeder.csv';
    }

    public function run()
    {
        // $datas = [[
        //     'id' => 1,
        //     'member_id' => '1615015166',
        //     'name' => 'Annasya Sintha Ambira' 
        // ],[
        //     'id' => 2,
        //     'member_id' => '1615015169',
        //     'name' => 'Aliifia Rosita' 
        // ],[
        //     'id' => 3,
        //     'member_id' => '1615015184',
        //     'name' => 'Gandhi Dwi Laksono' 
        // ],[
        //     'id' => 4,
        //     'member_id' => '1615015189',
        //     'name' => 'anas misbahuddin' 
        // ],[
        //     'id' => 5,
        //     'member_id' => '1615015191',
        //     'name' => 'abdul rahim' 
        // ]];

        // DB::table('members')->insert($datas);

        // Recommended when importing larger CSVs
		DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

        parent::run();
    }
}
