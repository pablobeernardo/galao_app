<?php

namespace App\Http\Controllers;

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
        // Validar entrada de dados
        $request->validate([
            'volume_galao' => 'required|numeric|min:0',
            'quantidade_garrafas' => 'required|integer|min:1',
            'garrafas' => 'required|array|min:' . $request->input('quantidade_garrafas'),
            'garrafas.*' => 'required|numeric|min:0',
        ]);

        $volumeGalao = $request->input('volume_galao');
        $garrafas = $request->input('garrafas');

        // Criar o galão e as garrafas
        $galao = Galao::create(['volume' => $volumeGalao]);
        foreach ($garrafas as $volumeGarrafa) {
            Garrafa::create(['volume' => $volumeGarrafa]);
        }

        // Encher o galão
        $encherGalaoService = new EncherGalaoService();
        $resultado = $encherGalaoService->encherGalao($galao, Garrafa::all());

        return redirect()->route('encher_galao.index')->with('resultado', [
            'galao' => $galao,
            'garrafas' => $resultado,
            'sobra' => $galao->volume - array_sum($resultado)
        ]);
    }
}
