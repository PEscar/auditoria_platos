<?php

use App\Models\Sector;
use App\Models\Sede;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User Pedro
        $user = factory(User::class)->create(['email' => 'pedroscarselletta@gmail.com', 'name' => 'Pedro Scarselletta']);

        Role::create(['name' => 'Admin']);
        $user->assignRole('Admin');

        Sede::create(['nombre' => 'Madero 1']);
        Sede::create(['nombre' => 'Madero 2']);
        Sede::create(['nombre' => 'Madero 3']);
        Sede::create(['nombre' => 'Madero 5']);
        Sede::create(['nombre' => 'Libertador']);
        Sede::create(['nombre' => 'Dolce']);
        Sede::create(['nombre' => 'Riobamba']);
        Sede::create(['nombre' => 'Botanico']);
        Sede::create(['nombre' => 'Recoleta']);
        Sede::create(['nombre' => 'San Isidro']);
        Sede::create(['nombre' => 'Pilar']);

        Sector::create(['nombre' => 'Fiambreria']);
        Sector::create(['nombre' => 'Pastas']);
        Sector::create(['nombre' => 'Minuta']);
        Sector::create(['nombre' => 'Fritadora']);
    }
}
