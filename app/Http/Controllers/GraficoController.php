<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicadores;
use Illuminate\Support\Facades\DB;

class GraficoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        
        return view('grafico');
    }

    public function getAllIndicadores(Request $request){
        
        if ( $request['fechaDesde'] != null || $request['fechaDesde']!= ""  ){

            $resultados = DB::select("SELECT `id`, `nombreIndicador`, `codigoIndicador`, `unidadMedidaIndicador`, `valorIndicador`, fechaIndicador FROM `historial_uf` 
            WHERE `fechaIndicador` >= '".$request['fechaDesde']."' AND `fechaIndicador` <= '".$request['fechaHasta']."'");

        }else{

            $resultados = DB::select("SELECT `id`, `nombreIndicador`, `codigoIndicador`, `unidadMedidaIndicador`, `valorIndicador`, fechaIndicador FROM `historial_uf`");

        }
        
        // $resultados = DB::select("SELECT * FROM `historial_uf`");
        return response()->json($resultados);

    }

   
}
