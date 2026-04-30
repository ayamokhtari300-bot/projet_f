<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // User::factory(10)->create();

        $agent = User::factory()->create([
            'name' => 'Agent User',
            'email' => 'agent@test.com',
            'password' =>  Hash::make('password'),
        ]);
        $agent->assignRole('agent');

        $operateur = User::factory()->create([
            'name' => 'Operateur User',
            'email' => 'operateur@test.com',
            'password' =>  Hash::make('password'),
        ]);
        $operateur->assignRole('operateur');

        $validateur = User::factory()->create([
            'name' => 'Validateur User',
            'email' => 'validateur@test.com',
            'password' =>  Hash::make('password'),
        ]);
        $validateur->assignRole('validateur');

        Vehicule::factory(5)->create();
    }
}
