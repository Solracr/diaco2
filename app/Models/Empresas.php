<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    
    protected $connection = 'diacoenlienadb';
    protected $table = 'empresa';
    // protected $primaryKey = 'ID';
    public $incrementing = true;

}
