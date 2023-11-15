<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
       //$data = User::where('status','1')->orderBy('id','DESC')->paginate(50);
       //return view('analista.migracion',compact('data'));
       $products = DB::connection('mysql')->select('SELECT count(*) as cantidad ,status FROM solicituds group by status');    
       return view('supervisor.dashboard',compact('products'));
    }

    public function grupos()
    {
        $result = DB::connection('mysql')->select('SELECT count(*) as cantidad ,status FROM masterpex.solicituds group by status');
        return $result;        

    }

}
