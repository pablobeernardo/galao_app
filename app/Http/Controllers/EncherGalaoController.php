<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Galao;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrosEnviadosMail; 
use App\Mail\RegistrosEnviados;
use Illuminate\Support\Facades\Log;

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

    public function enviarEmail(Request $request)
    {
        $galao_id = $request->galao_id;
        $registros_selecionados = $request->registros_selecionados;

        if (!$registros_selecionados) {
            return redirect()->back()->with('error', 'Por favor, selecione pelo menos um registro para enviar por e-mail.');
        }

        $registros = Registro::whereIn('id', $registros_selecionados)->get();
        $galao = Galao::findOrFail($galao_id);

        try {
            $anexos = [];

            foreach ($registros as $registro) {
                $csvData = $this->gerarDadosCSV($registro);
                $anexos[] = [
                    'data' => $csvData['content'],
                    'filename' => $csvData['fileName']
                ];
            }

            Mail::to($request->email)->send(new RegistrosEnviados($registros, $galao, $anexos));
            
            Log::info('E-mail enviado com sucesso para: ' . $request->email);
            return redirect()->back()->with('success', 'E-mail enviado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao enviar o e-mail: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao enviar o e-mail. Por favor, tente novamente mais tarde.');
        }
    }

    private function gerarDadosCSV($registro)
    {
        ob_start();
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Data e Hora', 'Volume do Galão (L)', 'Garrafas Utilizadas (L)', 'Sobra (L)']);
        fputcsv($file, [
            $registro->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s'),
            $registro->volume,
            implode(', ', json_decode($registro->garrafas_utilizadas)),
            $registro->sobra
        ]);
        fclose($file);
        $content = ob_get_clean();
        $fileName = 'encher_galao_resultado.csv';
        return compact('content', 'fileName');
    }
}
