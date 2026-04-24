<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccompagnateurSeeder extends Seeder
{
    /**
     * Ajouter des agents pouvant être sélectionnés comme accompagnateurs.
     */
    public function run(): void
    {
        $agents = [
            ['name' => 'Mohamed Amine',  'email' => 'amine@entreprise.dz'],
            ['name' => 'Fatima Zahra',   'email' => 'fatima@entreprise.dz'],
            ['name' => 'Karim Benali',   'email' => 'karim@entreprise.dz'],
            ['name' => 'Sara Boudiaf',   'email' => 'sara@entreprise.dz'],
            ['name' => 'Youcef Hamdi',   'email' => 'youcef@entreprise.dz'],
            ['name' => 'Nadia Khelil',   'email' => 'nadia@entreprise.dz'],
            ['name' => 'Raouf Mansouri', 'email' => 'raouf@entreprise.dz'],
            ['name' => 'Amira Oukil',    'email' => 'amira@entreprise.dz'],
        ];

        foreach ($agents as $data) {
            // Eviter les doublons si le seeder est relancé
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                ]
            );

            // Assigner le rôle 'agent' s'il n'est pas déjà assigné
            if (!$user->hasRole('agent')) {
                $user->assignRole('agent');
            }
        }

        $this->command->info('✅ ' . count($agents) . ' accompagnateurs ajoutés avec succès.');
    }
}
