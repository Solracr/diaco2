<?php

namespace App\Http\Controllers;

use App\Models\nivelacademico;
use Illuminate\Http\Request;

class NivelacademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return nivelacademico::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nivelacademico  $nivelacademico
     * @return \Illuminate\Http\Response
     */
    public function show(nivelacademico $nivelacademico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nivelacademico  $nivelacademico
     * @return \Illuminate\Http\Response
     */
    public function edit(nivelacademico $nivelacademico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\nivelacademico  $nivelacademico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nivelacademico $nivelacademico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nivelacademico  $nivelacademico
     * @return \Illuminate\Http\Response
     */
    public function destroy(nivelacademico $nivelacademico)
    {
        //
    }
}
