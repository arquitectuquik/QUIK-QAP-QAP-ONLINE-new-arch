<?php



class GrubbsV2
{



    private $factor_grubbs;

    private $resultados;

    private $new_array_resultados;

    private $factor_grubbs_utilizado;

    private $limite_inf;

    private $limite_sup;

    private $media_general;

    private $desvest_general;
    private $iqr;
    private $q1;
    private $q2;
    private $q3;



    public function __construct()
    {

        $this->new_array_resultados = array();

        $this->factor_grubbs = array(

            3 => 1.155,
            4 => 1.496,
            5 => 1.764,
            6 => 1.973,
            7 => 2.139,
            8 => 2.274,
            9 => 2.387,
            10 => 2.482,
            11 => 2.564,

            12 => 2.636,
            13 => 2.699,
            14 => 2.755,
            15 => 2.806,
            16 => 2.852,
            17 => 2.894,
            18 => 2.932,
            19 => 2.968,
            20 => 3.001,

            21 => 3.031,
            22 => 3.06,
            23 => 3.087,
            24 => 3.112,
            25 => 3.135,
            26 => 3.158,
            27 => 3.179,
            28 => 3.199,
            29 => 3.218,

            30 => 3.236,
            31 => 3.253,
            32 => 3.27,
            33 => 3.286,
            34 => 3.301,
            35 => 3.316,
            36 => 3.33,
            37 => 3.343,
            38 => 3.356,

            39 => 3.369,
            40 => 3.381,
            41 => 3.392,
            42 => 3.404,
            43 => 3.415,
            44 => 3.425,
            45 => 3.435,
            46 => 3.445,
            47 => 3.455,

            48 => 3.464,
            49 => 3.474,
            50 => 3.482,
            51 => 3.491,
            52 => 3.5,
            53 => 3.508,
            54 => 3.516,
            55 => 3.524,
            56 => 3.531,

            57 => 3.539,
            58 => 3.546,
            59 => 3.553,
            60 => 3.56,
            61 => 3.567,
            62 => 3.573,
            63 => 3.58,
            64 => 3.586,
            65 => 3.592,

            66 => 3.598,
            67 => 3.604,
            68 => 3.61,
            69 => 3.616,
            70 => 3.622,
            71 => 3.627,
            72 => 3.633,
            73 => 3.638,
            74 => 3.643,

            75 => 3.648,
            76 => 3.653,
            77 => 3.658,
            78 => 3.663,
            79 => 3.668,
            80 => 3.673,
            81 => 3.678,
            82 => 3.682,
            83 => 3.687,

            84 => 3.691,
            85 => 3.695,
            86 => 3.7,
            87 => 3.704,
            88 => 3.708,
            89 => 3.712,
            90 => 3.716,
            91 => 3.72,
            92 => 3.724,

            93 => 3.728,
            94 => 3.732,
            95 => 3.736,
            96 => 3.74,
            97 => 3.743,
            98 => 3.747,
            99 => 3.75,
            100 => 3.754

        );

        $this->factor_grubbs_utilizado = null;

        $this->limite_sup = null;

        $this->limite_inf = null;

    }




    public function ejecutar($array_resultados, $retornar_solo_atipicos = false)
    {
        return $this->exclusionAtipicos($array_resultados, $retornar_solo_atipicos);
    }

    public function exclusionAtipicos($array_resultados, $retornar_solo_atipicos = false)
    {



        $this->new_array_resultados = array();

        $this->resultados = $array_resultados;



        if (sizeof($this->resultados) > 2) {



            // Calculos generales

            $this->media_general = $this->stats_average($this->resultados);

            $this->desvest_general = $this->stats_standard_deviation($this->resultados, true);

            $n = sizeof($this->resultados);

            // Calcular cuartiles e IQR
            $this->calcularCuartiles();



            if ($n > 100) {

                $this->factor_grubbs_utilizado = $this->factor_grubbs[100];

            } else {

                $this->factor_grubbs_utilizado = $this->factor_grubbs[$n];

            }





            $this->limite_sup = $this->media_general + ($this->factor_grubbs_utilizado * $this->desvest_general);

            $this->limite_inf = $this->media_general - ($this->factor_grubbs_utilizado * $this->desvest_general);



            foreach ($array_resultados as $row_result) {

                // if ($retornar_solo_atipicos == true) {

                //     if ($row_result <= $this->limite_inf || $row_result >= $this->limite_sup) { // Si esta fuera los limites

                //         array_push($this->new_array_resultados, $row_result); // Agregelo al nuevo array

                //     }

                // } else {

                //     if ($row_result > $this->limite_inf && $row_result < $this->limite_sup) { // Si esta entre los limites

                array_push($this->new_array_resultados, $row_result); // Agregelo al nuevo array

                //     }

                // }



            }

        } else {

            if ($retornar_solo_atipicos == true) {

                $this->new_array_resultados = array();

            } else {

                $this->new_array_resultados = $array_resultados;

            }

        }



        return $this->new_array_resultados;

    }
    private function calcularCuartiles()
    {
        $n = count($this->resultados);

        if ($n == 0) {
            $this->q1 = $this->q2 = $this->q3 = 0;
            $this->iqr = 0;
            return;
        }

        sort($this->resultados, SORT_NUMERIC);

        // Método de interpolación lineal para cuartiles
        $this->q1 = $this->calcularPercentil(0.25);
        $this->q2 = $this->calcularPercentil(0.50); // Mediana
        $this->q3 = $this->calcularPercentil(0.75);
        $this->iqr = $this->q3 - $this->q1;
    }


    private function calcularPercentil($percentil)
    {
        $n = count($this->resultados);
        $position = ($n - 1) * $percentil;

        $low = floor($position);
        $high = ceil($position);

        if ($low == $high) {
            return $this->resultados[$low];
        }

        return $this->resultados[$low] + ($position - $low) *
            ($this->resultados[$high] - $this->resultados[$low]);
    }

    public function getPromediosNormales($columna)
    {
        // Usar los datos ya filtrados por exclusionAtipicos (guardados en new_array_resultados)
        if (empty($this->new_array_resultados)) {
            return [
                "media" => 0,
                "de" => 0,
                "cv" => 0,
                "n" => 0,
                "mediana" => 0,
                "q1" => 0,
                "q3" => 0
            ];
        }

        $valores = array_column($this->new_array_resultados, $columna);
        $n = count($valores);
        $media = $this->stats_average($valores);
        $de = $this->stats_standard_deviation($valores, true);
        $cv = ($media != 0) ? ($de / $media) * 100 : 0;

        // Calcular cuartiles
        $this->resultados = $valores;
        $this->calcularCuartiles();

        return [
            "media" => $media,
            "de" => $de,
            "cv" => $cv,
            "n" => $n,
            "mediana" => $this->get_q2(),
            "q1" => $this->get_q1(),
            "q3" => $this->get_q3()
        ];
    }

    // Getters para los cuartiles
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




    function stats_standard_deviation(array $a, $sample = false)
    {

        $n = count($a);

        if ($n === 0) {

            // trigger_error("The array has zero elements", E_USER_WARNING);

            return 0;

        }

        if ($sample && $n === 1) {

            // trigger_error("The array has only 1 element", E_USER_WARNING);

            return 0;

        }

        $mean = array_sum($a) / $n;

        $carry = 0.0;

        foreach ($a as $val) {

            $d = ((double) $val) - $mean;

            $carry += $d * $d;

        }
        ;

        if ($sample) {

            --$n;

        }

        return sqrt($carry / $n);

    }



    function stats_average($array)
    {

        if (count($array) == 0) {

            return 0;

        } else {

            return array_sum($array) / count($array);

        }

    }







    public function get_factor_grubbs_utilizado()
    {

        if (isset($this->factor_grubbs_utilizado)) {

            return round($this->factor_grubbs_utilizado, 5);

        }

        return " - - ";

    }



    public function get_limite_inf()
    {

        if (isset($this->limite_inf)) {

            return round($this->limite_inf, 5);

        }

        return " - - ";

    }



    public function get_limite_sup()
    {

        if (isset($this->limite_sup)) {

            return round($this->limite_sup, 5);

        }

        return " - - ";

    }





    public function get_media_general()
    {

        if (isset($this->media_general)) {

            return round($this->media_general, 5);

        }

        return " - - ";

    }

    public function get_desvest_general()
    {

        if (isset($this->desvest_general)) {

            return round($this->desvest_general, 5);

        }

        return " - - ";

    }



}