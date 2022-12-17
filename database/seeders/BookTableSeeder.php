<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class BookTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function __construct()
    {
        $this->table = 'books';
        $this->filename =  base_path().'/database/seeders/book_seeder.csv';
    }

    public function run()
    {
        // Recommended when importing larger CSVs
		DB::connection()->disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

        parent::run();
        

        // $this->command->getOutput()->progressStart(10);
        // for($i = 0; $i < 10; $i++){
        //     sleep(1);
        //     $this->command->getOutput()->progressAdvance();
        // }
        // $this->command->getOutput()->progressFinish();
    }
}
