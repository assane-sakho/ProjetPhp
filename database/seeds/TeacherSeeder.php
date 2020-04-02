<?php

use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            'email' => 'admin@parisnanterre.fr',
            'password' => 'admin'
        ]);
    }
}
