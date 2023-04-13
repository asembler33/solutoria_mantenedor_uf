<?php

namespace App\Http\Controllers;
use App\Models\Indicadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndicadoresUf extends Controller{

    
    public function index(){

        $dataIndicadores = DB::select("SELECT `id`, `nombreIndicador`, `codigoIndicador`, `unidadMedidaIndicador`, `valorIndicador`, fechaIndicador
                            FROM `historial_uf` WHERE codigoIndicador = 'UF'");
        // dd($dataIndicadores);
        return response()->json($dataIndicadores);
       
    }

    public function update( Request $request, $id ){

        
        $indicador = Indicadores::find($id);
        $indicador->valorIndicador = $request['valorIndicador'];
        $indicador->fechaIndicador = $request['fechaIndicador'];

        $indicador->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function store(Request $request){

  
        Indicadores::create([
            'nombreIndicador' => "UNIDAD DE FOMENTO (UF)",
            'codigoIndicador' => "UF",
            'unidadMedidaIndicador' => "Pesos",
            'valorIndicador' => $request['valorIndicador'],
            'fechaIndicador' => $request['fechaIndicador']
        ]);

        // Enviar una respuesta al cliente
        return response()->json([
            'success' => true
        ]);

    }

    public function destroy($id){
        $indicador = Indicadores::destroy($id);

        return $indicador;
    }


}
