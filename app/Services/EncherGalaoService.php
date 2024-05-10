<?php

namespace App\Services;

use App\Models\Galao;
use App\Models\Garrafa;

class EncherGalaoService
{
    public function encherGalao($volumeGalao, $quantidadeGarrafas, $capacidadesGarrafas)
    {
        $resultado = [];
        $volumeRestante = $volumeGalao;
        $garrafasOrdenadas = collect($capacidadesGarrafas)->sortDesc();
    
        foreach ($garrafasOrdenadas as $capacidade) {
            if ($capacidade <= $volumeRestante) {
                $resultado[] = $capacidade;
                $volumeRestante -= $capacidade;
            }
    
            if ($volumeRestante == 0) {
                break;
            }
        }
    
        return $resultado;
    }
    

    private function escolherGarrafas(Galao $galao, $garrafas)
    {
        $resultado = [];
        $volumeGalao = $galao->volume;

        // Ordena as garrafas pelo volume de forma decrescente
        usort($garrafas, function ($a, $b) {
            return $b['volume'] <=> $a['volume'];
        });

        // Percorre as garrafas para encher com água do galão
        foreach ($garrafas as $garrafa) {
            $volumeGarrafa = $garrafa['volume'];

            // Se o volume da garrafa for menor ou igual ao volume restante do galão
            if ($volumeGarrafa <= $volumeGalao) {
                // Adiciona o volume da garrafa ao resultado
                $resultado[] = $volumeGarrafa;
                // Reduz o volume do galão pelo volume da garrafa
                $volumeGalao -= $volumeGarrafa;
            }

            // Se o galão estiver vazio, interrompe o loop
            if ($volumeGalao == 0) {
                break;
            }
        }

        return $resultado;
    }



    private function armazenarResultado(Galao $galao, $resultado)
    {
        $filename = storage_path('exports/encher_galao_resultado.csv');

        $file = fopen($filename, 'w');
        fputcsv($file, ['Volume Garrafa']);
        foreach ($resultado as $volume) {
            fputcsv($file, [$volume]);
        }
        fputcsv($file, ['Sobra', $galao->volume - array_sum($resultado)]);
        fclose($file);
    }
    
}
