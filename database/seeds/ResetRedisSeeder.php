<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Redis;

class ResetRedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Redis::flushDB();
    }
}
