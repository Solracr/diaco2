<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuarios y asignacion de roles
        User::create([
            'name'              => 'admin',
            'user_name'          => 'admin',
            'email'             => 'admin@gmail.com',            
            'status'            => 1,
            'password'          => hash::make('12345678'),
            'remember_token'    => Str::random(10)

        ])->assignRole('sys_admin');
        //RoleUser::factory(1)->create(['role_id' => 1, 'user_id' => 1]);
        RoleUser::create(['role_id' => 1, 'user_id' => 1]);

        User::create([
            'name'              => 'Analista 1',
            'user_name'          => 'analista1',
            'email'             => 'analista1@mintrabajo.gob.gt',            
            'status'            => 1,
            'password'          => hash::make('12345678'),
            'remember_token'    => Str::random(10)

        ])->assignRole('analista');
        //RoleUser::factory(1)->create(['role_id' => 3, 'user_id' =>2]);
        RoleUser::create(['role_id' => 3, 'user_id' =>2]);

        User::create([
            'name'              => 'Supervisor',
            'user_name'          => 'supervisor',
            'email'             => 'supervisor@mintrabajo.gob.gt',            
            'status'            => 1,
            'password'          => hash::make('12345678'),
            'remember_token'    => Str::random(10)

        ])->assignRole('supervisor');
        //RoleUser::factory(1)->create(['role_id' => 6, 'user_id' => 3]);
        RoleUser::create(['role_id' => 6, 'user_id' => 3]);



         User::create([
            'name'              => 'firmante',
            'user_name'          => 'firmante',
            'email'             => 'firmante@mintrabajo.gob.gt',          
            'status'            => 1,
            'password'          => hash::make('12345678'),
            'remember_token'    => Str::random(10)

        ])->assignRole('firmante');
        //RoleUser::factory(1)->create(['role_id' => 8, 'user_id' => 4]);
        RoleUser::create(['role_id' => 8, 'user_id' => 4]);


        
        User::create([
            'name'              => 'usuario',
            'user_name'          => 'usuario',
            'email'             => 'usuario@mintrabajo.gob.gt',          
            'status'            => 1,
            'password'          => hash::make('12345678'),
            'remember_token'    => Str::random(10)

        ])->assignRole('usuario');
        //RoleUser::factory(1)->create(['role_id' => 8, 'user_id' => 4]);
        RoleUser::create(['role_id' => 5, 'user_id' => 5]);

    


    }
}
