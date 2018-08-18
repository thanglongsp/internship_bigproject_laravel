<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RoadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $limit = 100;

        for ($i = 1; $i <= $limit; $i++) {
	        DB::table('roads')->insert([
                'plan_id' => $faker->numberBetween($min = 1, $max = 20),
                'order_number' => $faker->numberBetween($min = 1, $max =3 ),//đánh thứ tự chuẩn cho faker
                'start_place'=>'Phạm Hùng, Keangnam, Nam Từ Liêm, Nam Từ Liêm Hà Nội',
                'end_place' => '91 Chùa Láng, Láng Thượng, Đống Đa, Hà Nội, Việt Nam',
                'start_time' =>'2018-05-02 10:38:45',
                'end_time' =>'2018-07-02 10:38:45',
                'vehicle'=> $faker->randomElement($array = array ('DRIVING','WALKING','BICYCLING','TRANSIT')),
                'action' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }
    }
}
