<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Galao;
use Illuminate\Support\Facades\Log;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;


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

        rsort($garrafas);

        $sobra = $volumeGalao;

        $garrafasUtilizadas = [];

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

    public function exportarCSV(Request $request)
    {
        $registro = Registro::where('galao_id', $request->galao_id)->latest()->first();

        return response()->streamDownload(function () use ($registro) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Data e Hora', 'Volume do Galão (L)', 'Garrafas Utilizadas (L)', 'Sobra (L)']);
            fputcsv($file, [
                $registro->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),
                $registro->volume,
                implode(', ', json_decode($registro->garrafas_utilizadas)),
                $registro->sobra
            ]);
            fclose($file);
        }, 'encher_galao_resultado.csv');
    }

  
    public function limparRegistro($id)
    {
        Registro::find($id)->delete();
        return redirect()->route('encher_galao.registros')->with('success', 'Registro excluído com sucesso!');
    }
   
}
