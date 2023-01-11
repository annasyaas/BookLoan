<?php

namespace Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanTableSeeder extends CsvSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function __construct()
    {
        $this->table = 'loans';
        $this->filename =  base_path().'/database/seeders/loan_seeder.csv';
    }

    public function run()
    {
        // $datas = [[
        //     'book_id' => 1,
        //     'member_id' => 1,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 3,
        //     'member_id' => 1,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 4,
        //     'member_id' => 1,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 5,
        //     'member_id' => 1,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 1,
        //     'member_id' => 2,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 3,
        //     'member_id' => 2,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 1,
        //     'member_id' => 2,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 5,
        //     'member_id' => 2,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 2,
        //     'member_id' => 3,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 3,
        //     'member_id' => 3,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 4,
        //     'member_id' => 3,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 5,
        //     'member_id' => 3,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 2,
        //     'member_id' => 4,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 3,
        //     'member_id' => 4,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 4,
        //     'member_id' => 4,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 1,
        //     'member_id' => 5,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 2,
        //     'member_id' => 5,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 4,
        //     'member_id' => 5,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ],[
        //     'book_id' => 5,
        //     'member_id' => 5,
        //     'copy_code' => 'QWERTY',
        //     'loan_date' => '19-12-2022',
        //     'date_returned' => '19-12-2022',
        //     'status' => 0
        // ]];

        // DB::table('loans')->insert($datas);

        // Recommended when importing larger CSVs
		DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

        parent::run();
    }
}
