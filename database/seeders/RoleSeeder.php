<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 =  Role::create(['name' => 'directorgeneral']);
        $role2 =  Role::create(['name' => 'gerentegeneral']);
        $role3 =  Role::create(['name' => 'administrador']);
        $role4 =  Role::create(['name' => 'asistente']);

        Permission::create(['name' => 'clientes.index', 'description' => 'Ver Cliente' ])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'clientes.create', 'description' => 'Crear Cliente' ])->assignRole($role3);
        Permission::create(['name' => 'clientes.edit', 'description' => 'Editar Cliente'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'clientes.destroy', 'description' => 'Eliminar Cliente'])->syncRoles([$role1, $role2]);


        Permission::create(['name' => 'findcustomer', 'description' => 'Ver Giros de Cliente'])->syncRoles([$role3, $role4]);

    }
}
