<?php

namespace App\Services;

use App\Models\Galao;
use App\Models\Garrafa;

class EncherGalaoService
{
    public function encherGalao(Galao $galao, $garrafas)
    {
        $resultado = $this->escolherGarrafas($galao, $garrafas);
        $this->armazenarResultado($galao, $resultado);
        return $resultado;
    }

    private function escolherGarrafas(Galao $galao, $garrafas)
    {
        $resultado = [];
        $volumeGalao = $galao->volume;

        foreach ($garrafas as $garrafa) {
            $volumeGarrafa = $garrafa->volume;

            if ($volumeGarrafa <= $volumeGalao) {
                $resultado[] = $volumeGarrafa;
                $volumeGalao -= $volumeGarrafa;
            }

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
