<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* User::create([
            'name' => 'Juan Fabrega',
            'email' => 'jjfabregam@gmail.com',
            'password' => bcrypt('Dirfix4u2023*')
        ])->assignRole('directorgeneral');
        User::create([
            'name' => 'Javier Fabrega',
            'email' => 'javier.fabrega@fix4u.solutions',
            'password' => bcrypt('Gerfix4u2023*')
        ])->assignRole('gerentegeneral');
        User::create([
            'name' => 'Lennys Garcia',
            'email' => 'administracion@fix4u.solutions',
            'password' => bcrypt('Admfix4u2023*')
        ])->assignRole('administrador');
        User::create([
            'name' => 'Luis Gonzalez',
            'email' => 'lgonzalez@fix4u.solutions',
            'password' => bcrypt('Asifix4u2023*')
        ])->assignRole('asistente'); */
        User::create([
            'name' => 'Andres Becerra',
            'email' => 'andres200605@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('directorgeneral');

        User::factory(9)->create();
    }
}
