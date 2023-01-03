<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // public function __construct()
    // {
    //     $this->table = 'books';
    //     $this->filename =  base_path().'/database/seeders/book_seeder.csv';
    // }

    public function run()
    {
        $datas = [[
            'id' => 1,
            'call_number' => 'QWER',
            'title' => 'Informatika',
            'copy' => 2,
            'publish_place' => 'Bandung',
            'publisher' => 'Gramedia',
            'isbn_issn' => 'QEQ1213'
        ],[
            'id' => 2,
            'call_number' => 'QWERTY',
            'title' => 'Matematika',
            'copy' => 2,
            'publish_place' => 'Jakarta',
            'publisher' => 'Gramedia Tbk',
            'isbn_issn' => 'QEQ12134'
        ],[
            'id' => 3,
            'call_number' => 'QWERTYUI',
            'title' => 'Bahasa Indonesia',
            'copy' => 1,
            'publish_place' => 'Yogyakarta',
            'publisher' => 'Gramedia',
            'isbn_issn' => 'QEQ121345'
        ],[
            'id' => 4,
            'call_number' => 'QWERTYUIO',
            'title' => 'Bahasa Inggris',
            'copy' => 3,
            'publish_place' => 'Surabaya',
            'publisher' => 'Gramedia',
            'isbn_issn' => 'QEQ1213456'
        ],[
            'id' => 5,
            'call_number' => 'QWERTYUIOP',
            'title' => 'Teknik Sipil',
            'copy' => 2,
            'publish_place' => 'Samarinda',
            'publisher' => 'Gramedia',
            'isbn_issn' => 'QEQ1456'
        ]];

        DB::table('books')->insert($datas);

        // Recommended when importing larger CSVs
		// DB::connection()->disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

        // parent::run();
        

        // $this->command->getOutput()->progressStart(10);
        // for($i = 0; $i < 10; $i++){
        //     sleep(1);
        //     $this->command->getOutput()->progressAdvance();
        // }
        // $this->command->getOutput()->progressFinish();
    }
}
