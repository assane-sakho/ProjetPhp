<?php

use Illuminate\Database\Seeder;

class TrainingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trainings')->insert([
            'id' => 1,
            'name' => 'Licence 3 Miage'
        ]);

        DB::table('trainings')->insert([
            'id' => 2,
            'name' => 'Master 1 Miage'
        ]);

        DB::table('trainings')->insert([
            'id' => 3,
            'name' => 'Master 2 Miage'
        ]);
    }
}
