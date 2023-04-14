<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\User;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'escritor']);

        $user = User::find(1);
        $user->assignRole('admin');
        $user = User::find(1);
        $user->assignRole('admin'); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
