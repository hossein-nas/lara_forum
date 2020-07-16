<?php

use Illuminate\Database\Seeder;

class ResetRedisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Redis::flushall();
    }
}
