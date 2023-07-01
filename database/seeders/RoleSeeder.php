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
        $role5 =  Role::create(['name' => 'desarrollo']);

 
        //CLIENTES
        Permission::create(['name' => 'clientes.index', 'description' => 'Ver Cliente' ])->syncRoles([$role5,$role1, $role2,$role3]); //asigna el permiso para mas de dos roles
        Permission::create(['name' => 'clientes.create', 'description' => 'Crear Cliente' ])->syncRoles([$role5,$role1,$role2]);//asigna el permiso para un rol
        Permission::create(['name' => 'clientes.edit', 'description' => 'Editar Cliente'])->syncRoles([$role5,$role1, $role2]);
        Permission::create(['name' => 'clientes.destroy', 'description' => 'Eliminar Cliente'])->syncRoles([$role1]);

        //PROVEEDORES
        Permission::create(['name' => 'supplier.index', 'description' => 'Ver Proveedor' ])->syncRoles([$role5,$role1, $role2, $role3, $role4]); 
        Permission::create(['name' => 'supplier.create', 'description' => 'Crear Proveedor' ])->syncRoles([$role5,$role1,$role3, $role4]);
        Permission::create(['name' => 'supplier.edit', 'description' => 'Editar Proveedor'])->syncRoles([$role5,$role1,$role3, $role4]);
        Permission::create(['name' => 'supplier.destroy', 'description' => 'Eliminar Proveedor'])->syncRoles([$role5,$role1, $role3, $role4]);

        //CONTROL DE USUARIOS
        Permission::create(['name' => 'users.index', 'description' => 'Ver Usuarios' ])->syncRoles([$role5,$role1]);
        Permission::create(['name' => 'users.create', 'description' => 'Editar Usuarios' ])->syncRoles($role5,$role1);
        Permission::create(['name' => 'users.edit', 'description' => 'Actualizar Usuarios'])->syncRoles([$role5,$role1]);

        //CONTROL DE ROLES
        Permission::create(['name' => 'roles.index', 'description' => 'Ver Roles' ])->syncRoles([$role5,$role1]); 
        Permission::create(['name' => 'roles.create', 'description' => 'Editar Roles' ])->syncRoles($role5,$role1);
        Permission::create(['name' => 'roles.edit', 'description' => 'Actualizar Roles'])->syncRoles([$role5,$role1]);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar Roles'])->syncRoles([$role5,$role1]);

        //NOMINA
        Permission::create(['name' => 'payroll.index', 'description' => 'Ver Nomina' ])->syncRoles([$role5,$role1,$role3]); 
        Permission::create(['name' => 'payroll.create', 'description' => 'Editar Empleado' ])->syncRoles($role5,$role1,$role3);
        Permission::create(['name' => 'payroll.edit', 'description' => 'Actualizar Empleado'])->syncRoles([$role5,$role1,$role3]);
        Permission::create(['name' => 'payroll.destroy', 'description' => 'Eliminar Empleado'])->syncRoles([$role5,$role1,$role3]);

        //GIROS DE COBRO
        Permission::create(['name' => 'findcustomer', 'description' => 'Ver Giros de Cliente'])->syncRoles([$role5,$role1,$role2,$role3]);
        Permission::create(['name' => 'createinvoiceing', 'description' => 'Crear Giros de Cliente'])->syncRoles([$role5,$role1, $role3]);
        
        //RECIBOS DE PAGO
        Permission::create(['name' => 'searchInvoice', 'description' => 'Buscar Clientes para Recibos de Ingreso'])->syncRoles([$role5,$role1, $role2, $role3]);
        Permission::create(['name' => 'findInvoice', 'description' => 'Ver Facturas Pendientes'])->syncRoles([$role5,$role1,$role2, $role3]);
        Permission::create(['name' => 'createIncome', 'description' => 'Crear Recibos de Pago'])->syncRoles([$role5,$role1, $role3]);

        //RELACION DE INGRESO
        Permission::create(['name' => 'searchIncome', 'description' => 'Ver Clientes para Realizar Relación de Ingreso'])->syncRoles([$role5,$role1, $role3]);
        Permission::create(['name' => 'findIncome', 'description' => 'Ver Relaciones de Ingreso Pendientes'])->syncRoles([$role5,$role1, $role3]);
        Permission::create(['name' => 'createIng', 'description' => 'Crear Relación de Ingreso'])->syncRoles([$role5,$role1, $role3]);

        //ORDEN DE COMPRA
        Permission::create(['name' => 'reportorder', 'description' => 'Lista de Ordenes de Compra Por Autorizar'])->syncRoles([$role5,$role1, $role2]);
        Permission::create(['name' => 'autorizar', 'description' => 'Autorizar Orden de Compra'])->syncRoles([$role5,$role1]);
        Permission::create(['name' => 'createorco', 'description' => 'Crear Orden de Compra'])->syncRoles([$role5,$role3,$role4]);
        Permission::create(['name' => 'deleteordercom', 'description' => 'Borrar Orden de Compra'])->syncRoles([$role5,$role1]);
        
        //ORDEN DE PAGO
        Permission::create(['name' => 'registerorder', 'description' => 'Ver Ordenes de Compra Aprobadas'])->syncRoles([$role5,$role1, $role2, $role3,$role4]);
        Permission::create(['name' => 'createpayorder', 'description' => 'Crear Orden de Pago'])->syncRoles([$role5,$role1,$role3,$role4]);

        //REGISTRO DE PAGO
        Permission::create(['name' => 'registerpay', 'description' => 'Ver Ordenes de Pago por Registrar'])->syncRoles([$role5,$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'createpay', 'description' => 'Crear Registro de Pago'])->syncRoles([$role5,$role1,$role3]);

        //RETENCIONES DE IVA
        Permission::create(['name' => 'listpay', 'description' => 'Ver Lista de Retenciones de IVA'])->syncRoles([$role5,$role1, $role3, $role4]);
        Permission::create(['name' => 'createretention', 'description' => 'Crear Retencion de IVA por Egresos'])->syncRoles([$role5,$role1,$role3,$role4]);
        Permission::create(['name' => 'createretening', 'description' => 'Crear Retencion de IVA por Ingresos'])->syncRoles([$role5,$role1,$role3,$role4]);

        //RETENCIONES ISLR
        Permission::create(['name' => 'findagent', 'description' => 'Ver Lista de Agentes de Retención'])->syncRoles([$role5,$role1, $role3, $role4]);
        Permission::create(['name' => 'listreten', 'description' => 'Ver Retenciones I.S.L.R Pendientes'])->syncRoles([$role5,$role1,$role3,$role4]);
        Permission::create(['name' => 'createislr', 'description' => 'Crear Retenciones I.S.L.R'])->syncRoles([$role5,$role1,$role3,$role4]);

        //PAGO DE NOMINA
        Permission::create(['name' => 'payemployee', 'description' => 'Pagar al Empleado'])->syncRoles([$role5,$role1,$role3]);

        //CARGOS DE EMPLEADOS
        Permission::create(['name' => 'chargescreate', 'description' => 'Crear Cargos de Empleado'])->syncRoles([$role5,$role1,$role3]);
        Permission::create(['name' => 'chargeedit', 'description' => 'Editar Cargos de Empleado'])->syncRoles([$role5,$role1,$role3]);
        Permission::create(['name' => 'chargesdelete', 'description' => 'Eliminar Cargos de Empleado'])->syncRoles([$role5,$role1,$role3]);

        //VALORES DE PAGO
        Permission::create(['name' => 'valueedit', 'description' => 'Editar Valores de Pago'])->syncRoles([$role5,$role1,$role3]);

        //PROYECCION DE GASTOS
        Permission::create(['name' => 'proyectgast', 'description' => 'Ver Proyección de Gastos'])->syncRoles([$role5,$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'createproyectgast', 'description' => 'Crear Proyección de Gastos'])->syncRoles([$role5,$role1,$role2]);

        //LIBRO DIARIO
        Permission::create(['name' => 'diarybook', 'description' => 'Generar Libro diario'])->syncRoles([$role5,$role1]);

        //REPORTES DE INGRESOS Y EGRESOS
        Permission::create(['name' => 'reporting', 'description' => 'Generar Reporte de Ingresos'])->syncRoles([$role5,$role1]);
        Permission::create(['name' => 'reportgast', 'description' => 'Generar Reporte de Egresos'])->syncRoles([$role5,$role1]);


    




    }
}
