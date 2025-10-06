<?php

class IntercuartilV2
{
    private $resultados;
    private $new_array_resultados;
    private $limite_inf;
    private $limite_sup;
    private $media_general;
    private $desvest_general;
    private $iqr;
    private $q1;
    private $q2;
    private $q3;

    public function ejecutar($array_resultados, $estado = false)
    {
        return $this->test_intercuartil($array_resultados, $estado);
    }

    private function test_intercuartil($array_resultados, $estado = false)
    {
        if (!is_array($array_resultados) || empty($array_resultados)) {
            $this->new_array_resultados = array();
            return $this->new_array_resultados;
        }

        sort($array_resultados, SORT_NUMERIC);
        $this->new_array_resultados = array();
        $this->resultados = $array_resultados;
        $n = count($this->resultados);

        // Cálculo de Q1 (percentil 25)
        $this->q1 = $this->calculate_percentile(0.25);

        // Cálculo de Q2/mediana (percentil 50)
        $this->q2 = $this->calculate_percentile(0.5);

        // Cálculo de Q3 (percentil 75)
        $this->q3 = $this->calculate_percentile(0.75);

        // Calcula el rango intercuartílico
        $this->iqr = $this->q3 - $this->q1;

        // Calcula los límites
        $this->limite_inf = $this->q1 - (1.5 * $this->iqr);
        $this->limite_sup = $this->q3 + (1.5 * $this->iqr);

        // Calculos generales
        $this->media_general = $this->stats_average($this->resultados);
        $this->desvest_general = $this->stats_standard_deviation($this->resultados, true);

        // Filtra los valores según el parámetro $estado
        foreach ($array_resultados as $row_result) {
            // if ($estado) {
            //     if ($row_result <= $this->limite_inf || $row_result >= $this->limite_sup) {
            //         array_push($this->new_array_resultados, $row_result);
            //     }
            // } else {
            //     if ($row_result > $this->limite_inf && $row_result < $this->limite_sup) {
            array_push($this->new_array_resultados, $row_result);
            // }
            // }
        }

        return $this->new_array_resultados;
    }

    private function calculate_percentile($percentile)
    {
        $n = count($this->resultados);
        if ($n === 0) {
            return 0;
        }

        $position = ($n - 1) * $percentile;
        $low = floor($position);
        $high = ceil($position);

        if ($low == $high) {
            return $this->resultados[$low];
        }

        $lowValue = $this->resultados[$low];
        $highValue = $this->resultados[$high];

        return $lowValue + ($position - $low) * ($highValue - $lowValue);
    }

    public function getPromediosNormales()
    {
        $defaults = array(

            "media" => 0,
            "de" => 0,
            "cv" => 0,
            "cv_robusto" => 0,
            "n" => 0,
            "mediana" => 0,
            "q1" => 0,
            "q3" => 0,
            "iqr" => 0,
            "s" => 0
        );

        if (empty($this->new_array_resultados)) {
            return $defaults;
        }

        $media = $this->stats_average($this->new_array_resultados);
        $de = $this->stats_standard_deviation($this->new_array_resultados, true);
        $cv = ($media == 0) ? 0 : (($de / $media) * 100);
        $n = count($this->new_array_resultados);


        return array(
            "media" => $media,
            "de" => $de,
            "cv" => $cv,
            "cv_robusto" => (((($this->get_q1()) - ($this->get_q3())) / 1.349) / $this->get_q2()) * 100,
            "n" => $n,
            "mediana" => $this->get_q2(),
            "q1" => $this->get_q1(),
            "q3" => $this->get_q3(),
            "iqr" => ($this->get_q1()) - ($this->get_q3()),
            "s" => (($this->get_q1()) - ($this->get_q3())) / 1.349
        );

    }

    private function stats_standard_deviation(array $a, $sample = true)
    {
        $n = count($a);
        if ($n === 0) {
            return 0;
        }
        if ($sample && $n === 1) {
            return 0;
        }

        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((float) $val) - $mean;
            $carry += $d * $d;
        }

        if ($sample) {
            --$n;
        }
        return sqrt($carry / $n);
    }

    private function stats_average($array)
    {
        if (count($array) == 0) {
            return 0;
        }
        return array_sum($array) / count($array);
    }

    public function get_q1()
    {
        return isset($this->q1) ? round($this->q1, 5) : 0;
    }

    public function get_q2()
    {
        return isset($this->q2) ? round($this->q2, 5) : 0;
    }

    public function get_q3()
    {
        return isset($this->q3) ? round($this->q3, 5) : 0;
    }

    public function get_iqr()
    {
        return isset($this->iqr) ? round($this->iqr, 5) : 0;
    }

    public function get_limite_inf()
    {
        return isset($this->limite_inf) ? round($this->limite_inf, 5) : 0;
    }

    public function get_limite_sup()
    {
        return isset($this->limite_sup) ? round($this->limite_sup, 5) : 0;
    }

    public function get_media_general()
    {
        return isset($this->media_general) ? round($this->media_general, 5) : 0;
    }

    public function get_desvest_general()
    {
        return isset($this->desvest_general) ? round($this->desvest_general, 5) : 0;
    }

    public function getResultadosEscogidos()
    {
        return isset($this->new_array_resultados) ? $this->new_array_resultados : array();
    }
}