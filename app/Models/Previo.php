<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Previo extends Model
{
    protected $connection = 'mysql';
    protected $guarded = [];
    use HasFactory;
}
