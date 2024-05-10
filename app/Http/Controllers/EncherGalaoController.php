<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Galao;

class EncherGalaoController extends Controller
{
    public function index()
    {
        return view('encher_galao');
    }

    public function store(Request $request)
    {
        $volumeGalao = $request->input('volume_galao');
        $quantidadeGarrafas = $request->input('quantidade_garrafas');
        $garrafas = $request->input('garrafas');

        // Ordenar as garrafas em ordem decrescente
        rsort($garrafas);

        // Inicializa a sobra como o volume do galão
        $sobra = $volumeGalao;

        // Inicializa o array de garrafas utilizadas
        $garrafasUtilizadas = [];

        // Enche as garrafas até que o galão esteja vazio ou não haja mais garrafas
        foreach ($garrafas as $garrafa) {
            if ($sobra >= $garrafa) {
                $sobra -= $garrafa;
                $garrafasUtilizadas[] = $garrafa;
            }
        }

        $registro = new Registro();
        $registro->volume = $volumeGalao;
        $registro->garrafas_utilizadas = json_encode($garrafasUtilizadas);
        $registro->sobra = $sobra;
        $registro->galao_id = Galao::create(['volume' => $volumeGalao])->id;
        $registro->save();

        return redirect()->route('encher_galao.registros');
    }



    public function registros()
    {
        $registros = Registro::with('galao.garrafas')->get();
        return view('registros', compact('registros'));
    }


}
