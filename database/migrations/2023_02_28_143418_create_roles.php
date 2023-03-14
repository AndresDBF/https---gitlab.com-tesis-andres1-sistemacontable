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
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'escritor']);
        
<<<<<<< HEAD
        $user = User::find(1);
        $user->assignRole('admin');
=======
        //$user = User::find(1);
        //$user->assignRole('admin');
>>>>>>> c460ca5a5f5823c6756f45eaaa57e9aec497af78
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
