<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;

    protected $table = 'boletas_canceladas';
    protected $primaryKey = 'id_bol';
    public $incrementing = true;
    public $timestamps = false;
}
