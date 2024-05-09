<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galao;
use App\Models\Garrafa;
use App\Services\EncherGalaoService;

class EncherGalaoController extends Controller
{
    public function index()
    {
        return view('encher_galao');
    }

    public function store(Request $request)
    {
        //validar a entrada de dados
        $request->validate([
            'volume_galao' => 'required|numeric|min:0',
            'garrafas_csv' => 'required',
        ]);

        $volumeGalao = $request->input('volume_galao');
        $garrafasCSV = $request->input('garrafas_csv');

        // Processar o CSV de garrafas
        $garrafas = explode(',', $garrafasCSV);

        // Criar o galão e as garrafas
        $galao = Galao::create([
            'volume' => $volumeGalao,
        ]);
        foreach ($garrafas as $volumeGarrafa) {
            Garrafa::create([
                'volume' => $volumeGarrafa,
            ]);
        }

        // Encher o galão
        $encherGalaoService = new EncherGalaoService();
        $resultado = $encherGalaoService->encherGalao($galao, Garrafa::all());

        return redirect()->route('encher_galao.index')->with('resultado', $resultado);
    }
}



