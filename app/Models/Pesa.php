<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_presentacion',
        'boleta',
        'correoelectronico',
        'nombre_empresa',
        'nombre_comercial',
        'direccion',
        'departamento',
        'municipio',
        'telefono',
        'fax',
        'responsable',
        'cargo',
        'serie',
        'marca',
        'origen',
        'area',
        'tipobalanza',
        'otrosdatos',
    ];
}
