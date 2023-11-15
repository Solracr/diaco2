<?php

// app/Models/Formulario63A.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario63A extends Model
{
    protected $table = 'formulario_63as';

    protected $fillable = [
        'recibo', 'regional', 'fecha', 'consumidor', 'lugar', 'deposito', 'codigo_multa', 'oficina', 'rubro', 'cantidad'
    ];
}
