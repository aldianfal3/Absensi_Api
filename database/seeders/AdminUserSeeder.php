<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('table_user')->insert([
            'nama' => 'Muhamad Aldi S',
            'email' => 'al********@gmail.com',
            'password' => bcrypt('GMdelta004'),
            'username' => 'Evotime',
        ]);
    }
}
