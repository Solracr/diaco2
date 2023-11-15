<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


         $this->call(DepartamentoSeeder::class);
         $this->call(MunicipioSeeder::class);
         $this->call(RoleSeeder::class);
         $this->call(UserSeeder::class);
         

         /*User::factory(1)->create([
             'name' => 'Admin',
             'user_name' => 'admin',
             'email' => 'creativo@gmail.com',
             'email_verified_at' => now(),
             'password' => Hash::make('12345678'),
             'status'   => 1
         ]);

         User::factory(10)->create();*/


    }
}
