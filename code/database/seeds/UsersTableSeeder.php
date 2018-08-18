<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); 
        $limit = 10;
        DB::table('users')->insert([
            'name' => 'Oshiro Mugen',
            'email' => 'oshiro.mugen@jp.com',
            'gender'=>1,
            'birthday' => $faker->date,
            'avatar'=> 'avatar11.jpg',
            'phone_number' => $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'remember_token'=>null
        ]);
        for ($i = 1; $i <= $limit; $i++) {
	        DB::table('users')->insert([
	            'name' => $faker->name,
                'email' => $faker->email,
                'gender'=>$faker->randomElement($array = array ('1','2')),
                'birthday' => $faker->date,
                'avatar'=> 'avatar'.$i.'.jpg',
                'phone_number' => $faker->phoneNumber,
                'password' => bcrypt('secret'),
                'remember_token'=>null
            ]);
        }
    }
}
