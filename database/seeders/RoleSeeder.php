<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            ['name' => 'sys_admin'],     //1
            ['name' => 'administrador'], //2
            ['name' => 'analista'],      //3
            ['name' => 'empresa'],       //4
            ['name' => 'usuario'],    //5
            ['name' => 'supervisor'],    //6
            ['name' => 'revisor'],       //7
            ['name' => 'firmante'],      //8            
            ['name' => 'libros'],      //9
            ['name' => 'pesas'],      //10
        ];

        foreach ($roles as $role){
            Role::create($role);
        }

        Permission::create(['name' => 'home'])->assignRole([1,2,3,4,5,6,7,8]);
        Permission::create(['name' => 'empresa.grid_listado_empresa'])->assignRole([1,5]);
        Permission::create(['name' => 'empresa.grid_expedientes_empresa'])->assignRole([1,5]);
        Permission::create(['name' => 'solicitud.grid_expedientes'])->assignRole([1,5]);
        Permission::create(['name' => 'empresa.webservice'])->assignRole([1,5]);
        Permission::create(['name' => 'empresa.nit'])->assignRole([1,5]);
        Permission::create(['name' => 'solicitud.form_solicitud'])->assignRole([1,5]);
        Permission::create(['name' => 'solicitud.form_solicitud_empresa_actualizar'])->assignRole([1,5]);
        Permission::create(['name' => 'solicitud.form_requisitos_empresa'])->assignRole([1,5]);        
        Permission::create(['name' => 'bitacora.gridBitacora'])->assignRole([1,2,3,4,5]);
        Permission::create(['name' => 'adjuntos.form_upload_file'])->assignRole([1,5]);
        Permission::create(['name' => 'libros'])->assignRole([1,9]);
        Permission::create(['name' => 'pesas'])->assignRole([1,10]);
        
        // Analistas
        Permission::create(['name' => 'analista.mesatrabajo'])->assignRole([1,2,3,4,6,8]);
        Permission::create(['name' => 'analista.analista'])->assignRole([1,3]);        
        Permission::create(['name' => 'analista.supervisor'])->assignRole([1,6]);        
        Permission::create(['name' => 'analista.firmante'])->assignRole([1,8]);        

// Supervisor
Permission::create(['name' => 'admin.sgc'])->assignRole([1,4]);
Permission::create(['name' => 'admin.informatica'])->assignRole([1,7]);   

        Permission::create(['name' => 'super.user'])->assignRole([1]);   
        
        
                     
          
        
    }
}
