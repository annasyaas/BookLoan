<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(BookTableSeeder::class);  
        // $this->call(MemberTableSeeder::class);        
        $this->call(UserSeederTable::class);      
        // $this->call(LoanTableSeeder::class);        
    }
}
