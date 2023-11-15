<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamentos =[

            [ 'nombre' => 'Guatemala'],
            [  'nombre' => 'El Progreso'],
            [  'nombre' => 'Sacatepéquez'],
            [ 'nombre' => 'Chimaltenango'],
            [ 'nombre' => 'Escuintla'],
            [  'nombre' => 'Santa Rosa'],
            [  'nombre' => 'Sololá'],
            [  'nombre' => 'Totonicapán'],
            [  'nombre' => 'Quetzaltenango'],
            [  'nombre' => 'Suchitepéquez'],
            [  'nombre' => 'Retalhuleu'],
            [  'nombre' => 'San Marcos'],
            [  'nombre' => 'Huehuetenango'],
            [  'nombre' => 'Quiché'],
            [  'nombre' => 'Baja Verapaz'],
            [  'nombre' => 'Alta Verapaz'],
            [  'nombre' => 'Petén'],
            [  'nombre' => 'Izabal'],
            [  'nombre' => 'Zacapa'],
            [  'nombre' => 'Chiquimula'],
            [  'nombre' => 'Jalapa'],
            [  'nombre' => 'Jutiapa'],
        ];
        foreach ($departamentos as $departamento){
            Departamento::create($departamento);
        }
    }
}
