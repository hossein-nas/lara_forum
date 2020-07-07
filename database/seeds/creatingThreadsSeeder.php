<?php

use App\User;
use App\Thread;
use Illuminate\Database\Seeder;

class creatingThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Thread::class, 30)->create();
        factory(User::class)
            ->create(['name' => "JohnDoe", "email" => "john@example.com", "password" => bcrypt("password")]);
    }
}
