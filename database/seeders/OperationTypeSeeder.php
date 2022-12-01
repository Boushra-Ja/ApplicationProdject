<?php

namespace Database\Seeders;

use App\Models\OperationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('operation_types')->insert(
            [
                'type' => 'حجز'
            ],
        );
        DB::table('operation_types')->insert(
            [
                'type' => 'الغاء حجز'
            ]

        );
        DB::table('operation_types')->insert(
            [
                'type' => 'حذف'
            ],

        );
        DB::table('operation_types')->insert(
            [
                'type' => 'انشاء'
            ],

        );
        DB::table('operation_types')->insert(
            [
                'type' => 'تعديل'
            ],
        );

    }

}


