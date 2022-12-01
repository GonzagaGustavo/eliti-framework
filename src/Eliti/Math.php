<?php

class Eliti_Math
{
    public function getDesvioPadrao($arrValues)
    {
        $varianciaPopulacional =
            $this->somaQuadradoDesvio($arrValues) / count($arrValues);
        $desvioPadraoPopulacional = sqrt($varianciaPopulacional);
        return $desvioPadraoPopulacional;
    }

    private function media($arrValues)
    {
        $media = array_sum($arrValues) / count($arrValues);
        return $media;
    }

    private function somaQuadradoDesvio($arrValues)
    {
        $somaQuadradoDesvio = 0;
        foreach ($arrValues as $soma => $value) {
            $desvio = $value - $this->media($arrValues);
            $quadradoDesvio = pow($desvio, 2);
            $somaQuadradoDesvio += $quadradoDesvio;
        }
        return $somaQuadradoDesvio;
    }
}
