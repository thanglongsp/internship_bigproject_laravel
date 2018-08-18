<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
	        DB::table('comments')->insert([
                'plan_id' => 1,
                'parent_id'=>null,
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'content'=> $faker->sentence($nbWords = 6, $variableNbWords = true),
                'created_at' =>'2018-06-02 09:38:45',
                'checkin_location'=>'CD3, Yên Hoà, Cầu Giấy, Hà Nội, Vietnam',
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
	        DB::table('comments')->insert([
                'plan_id' => 1,
                'parent_id'=>1,
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'content'=> $faker->sentence($nbWords = 6, $variableNbWords = true),
                'created_at' =>'2018-06-02 10:38:45',
                'checkin_location'=>'91 Chùa Láng, Láng Thượng, Đống Đa, Hà Nội, Việt Nam',
            ]);
        }
    }
}
