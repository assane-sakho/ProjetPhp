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
            'title' => 'En cours de finalisation'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Reçu'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Reçu incomplet en attente de complément'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Validé complet'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Entretien'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Accepté'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Refusé'
        ]);

        DB::table('registration_statuses')->insert([
            'title' => 'Liste d’attente'
        ]);
    }
}
