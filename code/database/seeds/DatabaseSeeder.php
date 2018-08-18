<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(SlidesTableSeeder::class);
    	$this->call(UsersTableSeeder::class);
    	$this->call(PlansTableSeeder::class);
    	$this->call(RoadsTableSeeder::class);
    	$this->call(CommentsTableSeeder::class);
    }
}