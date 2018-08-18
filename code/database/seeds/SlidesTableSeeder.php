<?php

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
            $q=$i+1;
            DB::table('slides')->insert([
                'banner' => 'banner'.$q.'.jpg'
            ]);
        }
    }
}
