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
        $listaPermisos = ["adm-ventas","cajero","adm-rh","adm-cred-prov","colaborador","adm-gerencia","adm-marketing"];
        $permisosGerente = ["adm-ventas","cajero","adm-rh","adm-cred-prov","adm-gerencia","colaborador","adm-marketing"];
        $permisosInventario = ["adm-ventas","cajero","colaborador","adm-marketing"];
        $permisosVendedor = ["cajero", "colaborador"];

        $listaRoles = ["Gerente","Vendedor","Bodega"];

        /*$roleGerente =Role::create(["name"=>"Gerente"]);
        $roleCajero = Role::create(["name"=>"Sub-Gerente"]);
        $roleColaborador = Role::create(["name"=>"Colaborador"]);*/
        foreach($listaRoles as $rol){
            Role::create(["name"=>$rol]);
        }
        /*Creación de permisos*/
        $permissionVentas = Permission::create(["name"=>"Ventas"]);
        /*Creación de permisos*/
        foreach($listaPermisos as $permiso){
            Permission::create(["name"=>$permiso]);
        }

        foreach ($permisosGerente as $permiso){
            Role::findByName("Gerente")->givePermissionTo($permiso);
        }
        foreach($permisosInventario  as $permiso){
            Role::findByName("Bodega")->givePermissionTo($permiso);
        }
        foreach($permisosVendedor as $permiso){
            Role::findByName("Vendedor")->givePermissionTo($permiso);
        }

        $user = User::create([
            "id_empleado"=>1,
            "name"=>"Gerente",
            "email"=>"gerente@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Gerente");

        $user = User::create([
            "id_empleado"=>2,
            "name"=>"Jefe de Bodega",
            "email"=>"bodega@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Bodega");

        $user = User::create([
            "id_empleado"=>3,
            "name"=>"PG21005",
            "email"=>"PG21005@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Vendedor");


        $user = User::create([
            "id_empleado"=>4,
            "name"=>"RR20104",
            "email"=>"RR20104@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Vendedor");

        $user = User::create([
            "id_empleado"=>5,
            "name"=>"DC19019",
            "email"=>"DC19019@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Vendedor");

        $user = User::create([
            "id_empleado"=>6,
            "name"=>"VN21007",
            "email"=>"VN21007@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Vendedor");


        /*
        $user = User::create([
            "id_empleado"=>1,
            "name"=>"Morgott",
            "email"=>"luis@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Gerente");

        $user = User::create([
            "id_empleado"=>2,
            "name"=>"Margit",
            "email"=>"teobaldo@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Sub-Gerente");

        $user = User::create([
            "id_empleado"=>3,
            "name"=>"MaleniaBladeOfMiquella",
            "email"=>"leonardo@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Colaborador");


        $user = User::create([
            "id_empleado"=>4,
            "name"=>"Miquella",
            "email"=>"gabriela@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Colaborador");

        $user = User::create([
            "id_empleado"=>5,
            "name"=>"Tarnished",
            "email"=>"david@gmail.com",
            "password"=>bcrypt("password")
        ]);
        $user->assignRole("Colaborador"); */
    }
}