<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileStatusSeeder extends Seeder
{

    public function run()
    {
        DB::table('file_statuses')->insert(
            [
                'status' => 'حر'
            ],
        );
        DB::table('file_statuses')->insert(
            [
                'status' => 'محجوز'
            ]

        );


    }
}
