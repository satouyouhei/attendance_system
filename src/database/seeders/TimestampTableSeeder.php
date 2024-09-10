<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timestamp;
use Illuminate\Support\Facades\DB;


class TimestampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Timestamp::factory()->count(300)->create();
    }
}
