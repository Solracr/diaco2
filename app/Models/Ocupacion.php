<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = "ocupacions";
    protected $connection = 'mysql';
    use HasFactory;
}
