<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisosGerente = ["all"];
        $permisosSubGerente = ["Ventas","Inventario","Recursos Humanos"];
        $permisosCajero = ["Ventas"];
        $permisosEmpleado = ["Recursos Humanos"];

        $roleSubGerente = Role::create(["name"=>"Sub-Gerente"]);
        $roleGerente =Role::create(["name"=>"Gerente"]);
        $roleCaja = Role::create(["name"=>"Caja"]);
        $roleEmpleado = Role::create(["name"=>"Empleado"]);
        /*Creación de permisos*/
        $permissionVentas = Permission::create(["name"=>"Ventas"]);
        $permissionRH = Permission::create(["name"=>"Recursos Humanos"]);
        $permissionInventario = Permission::create(["name"=>"Inventario"]);
        $permissionSeguridad = Permission::create(["name"=>"Seguridad"]);
        $permissionMarketing = Permission::create(["name"=>"Marketing"]);
        $permissionAll = Permission::create(["name"=>"all"]);

        foreach ($permisosGerente as $permiso){
            $roleGerente->givePermissionTo($permiso);
        }
        foreach($permisosCajero  as $permiso){
            $roleCaja->givePermissionTo($permiso);
        }

        $user = User::create([
            "id_empleado"=>3,
            "name"=>"juanillo",
            "email"=>"juanacosta_555@gmail.com",
            "password"=>bcrypt("password")
        ]);

        $user->assignRole("Gerente");
        $user = User::create([
            "id_empleado"=>4,
            "name"=>"juanillo100",
            "email"=>"juanacosta4200@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Caja");
    }
}