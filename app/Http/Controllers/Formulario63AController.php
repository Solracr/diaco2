<?php

namespace App\Http\Controllers;

use App\Models\Formulario63A;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrosExport;


class Formulario63AController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    public function get()
    {
        $year = now()->year;
        $registros = Formulario63A::whereYear('created_at', $year)->get();
        return response()->json($registros);
    }

    public function export()
    {
        return Excel::download(new RegistrosExport, 'reportef63a.xlsx');
    }
   

    public function store(Request $request)
    {
        // Validate the request data except 'oficina'
        $data = $request->validate([
            'recibo' => 'required|string',
            'regional' => 'required|string',
            'fecha' => 'required|date',
            'consumidor' => 'nullable|string',
            'lugar' => 'nullable|string',
            'deposito' => 'required|string',
            // 'oficina' => 'required|string', // This line is commented out to allow a default value
            'rubro' => 'required|string',
            'cantidad' => 'required|integer',
        ]);
        
        // Provide a default value for 'oficina' if it's not present in the request
        $data['oficina'] = $request->input('oficina', 'DIACO');
    
        // Create a new Formulario63A with the validated data
        $form = Formulario63A::create($data);
        
        // Return the newly created Formulario63A with a 201 status code
        return response()->json($form, 201);
    }
    
    public function show(Formulario63A $formulario63A)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formulario63A  $formulario63A
     * @return \Illuminate\Http\Response
     */
    public function edit(Formulario63A $formulario63A)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formulario63A  $formulario63A
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formulario63A $formulario63A)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formulario63A  $formulario63A
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formulario63A $formulario63A)
    {
        //
    }
}
