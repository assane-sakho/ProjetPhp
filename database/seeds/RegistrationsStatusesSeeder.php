<?php

use Illuminate\Database\Seeder;

class RegistrationsStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registration_statuses')->insert([
            'id' => 1,
            'title' => 'En cours de finalisation'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 2,
            'title' => 'Reçu'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 3,
            'title' => 'Reçu incomplet en attente de complément'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 4,
            'title' => 'Validé complet'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 5,
            'title' => 'Entretien'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 6,
            'title' => 'Accepté'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 7,
            'title' => 'Refusé'
        ]);

        DB::table('registration_statuses')->insert([
            'id' => 8,
            'title' => 'Liste d’attente'
        ]);
    }
}
