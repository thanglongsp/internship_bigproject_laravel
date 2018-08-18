<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $limit = 20;

        for ($i = 1; $i <= $limit; $i++) {
	        DB::table('plans')->insert([
	            'name' => $faker->text($maxNbChars = 10),
                'start_place'=>'Phạm Hùng, Keangnam, Nam Từ Liêm, Nam Từ Liêm Hà Nội',
                'end_place' => '91 Chùa Láng, Láng Thượng, Đống Đa, Hà Nội, Việt Nam',
                'start_time' =>'2018-05-02 10:38:45',
                'end_time' =>'2018-07-02 10:38:45',
                'status'=> $faker->numberBetween($min = 1, $max = 3),
                'picture' => 'plan'.$i.'.jpg',
            ]);
        }
    }
}
