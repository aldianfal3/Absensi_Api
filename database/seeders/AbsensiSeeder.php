<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('table_absensi')->insert([
            'id' => '1',
            'nama' => 'M.Aldi',
            'status' => 'izin',
            'created_at' => now(),
            'updated_at' => now()
            
        ]);
        
    }
}
