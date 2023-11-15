<?php

namespace App\Http\Controllers;

use App\Models\Ocupacion;
use Illuminate\Http\Request;

class OcupacionController extends Controller
{
    

    
    public function index()
    {
        return Ocupacion::all();                   
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }

   
    public function show(Ocupacion $ocupacion)
    {
        //
    }

   
    public function edit(ocupacion $ocupacion)
    {
        //
    }

    public function update(Request $request, Ocupacion $ocupacion)
    {
        //
    }

    public function destroy(Ocupacion $ocupacion)
    {
        //
    }
}
