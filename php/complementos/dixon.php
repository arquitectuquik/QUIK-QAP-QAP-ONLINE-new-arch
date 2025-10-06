<?php



class Dixon
{



    private $factor_dixon;

    private $resultados;

    private $new_array_resultados;

    private $factor_dixon_utilizado;

    private $limite_inf;

    private $limite_sup;

    private $media_general;

    private $desvest_general;



    public function __construct()
    {

        $this->new_array_resultados = array();

        $this->factor_dixon = array(



            3 => 0.8850,
            4 => 0.6789,
            5 => 0.5578,
            6 => 0.4840,
            7 => 0.4340,
            8 => 0.3979,
            9 => 0.3704,
            10 => 0.3492,
            11 => 0.3312,
            12 => 0.3170,

            13 => 0.3045,
            14 => 0.2938,
            15 => 0.2848,
            16 => 0.2765,
            17 => 0.2691,
            18 => 0.2626,
            19 => 0.2564,
            20 => 0.2511,
            21 => 0.2460,
            22 => 0.2415,

            23 => 0.2377,
            24 => 0.2337,
            25 => 0.2303,
            26 => 0.2269,
            27 => 0.2237,
            28 => 0.2208,
            29 => 0.2182,
            30 => 0.2155,
            31 => 0.2132,
            32 => 0.2110,

            33 => 0,
            2088,
            34 => 0.2066,
            35 => 0.2045,
            36 => 0.2026,
            37 => 0.2008,
            38 => 0.1993,
            39 => 0.1974,
            40 => 0.1484,
            41 => 0.1944,
            42 => 0.1930,

            43 => 0.1915,
            44 => 0.1902,
            45 => 0.1890,
            46 => 0.1875,
            47 => 0.1865,
            48 => 0.1850,
            49 => 0.1839,
            50 => 0.1829,
            51 => 0.1819,
            52 => 0.1808,

            53 => 0.1797,
            54 => 0.1788,
            55 => 0.1777,
            56 => 0.1768,
            57 => 0.1759,
            58 => 0.1752,
            59 => 0.1741,
            60 => 0.1733,
            61 => 0.1726,
            62 => 0.1717,

            63 => 0.1707,
            64 => 0.1703,
            65 => 0,
            1694,
            66 => 0.1689,
            67 => 0.1679,
            68 => 0.1674,
            69 => 0.1667,
            70 => 0.1660,
            71 => 0.1652,
            72 => 0.1648,

            73 => 0.1641,
            74 => 0.1635,
            75 => 0.1631,
            76 => 0.1626,
            77 => 0.1620,
            78 => 0.1613,
            79 => 0.1605,
            80 => 0.1601,
            81 => 0.1596,
            82 => 0.1594,

            83 => 0.1586,
            84 => 0.1583,
            85 => 0.1576,
            86 => 0.1573,
            87 => 0.1567,
            88 => 0.1563,
            89 => 0.1557,
            89 => 0.1554,
            91 => 0.1547,
            92 => 0.1544,

            93 => 0.1540,
            94 => 0.1537,
            95 => 0.1532,
            96 => 0.1528,
            97 => 0.1524,
            98 => 0.1521,
            99 => 0.1516,
            100 => 0.1512



        );



        $this->factor_dixon_utilizado = null;



        $this->limite_sup = null;



        $this->limite_inf = null;



    }





    function exclusionAtipicos($array_resultados, $columna, $retornar_solo_atipicos = false)
    {

        $this->new_array_resultados = array();

        $this->resultados = array_column($array_resultados, $columna);



        // Calculos generales

        $this->media_general = $this->stats_average($this->resultados);

        $this->desvest_general = $this->stats_standard_deviation($this->resultados, true);

        $n = sizeof($this->resultados);



        if ($n > 100) {

            $this->factor_dixon_utilizado = $this->factor_dixon[100];

        } else {

            $this->factor_dixon_utilizado = $this->factor_dixon[$n];

        }



        // Limite superior e inferior



        $this->dato_menor = $array_resultados[0]['resultado'];

        $this->segundo_dato_menor = $array_resultados[1]['resultado'];

        $numeroresultado = count($array_resultados);

        $this->dato_mayor = $array_resultados[$numeroresultado - 1]['resultado'];

        $this->segundo_dato_mayor = $array_resultados[$numeroresultado - 2]['resultado'];



        $this->limite_sup = ($this->dato_mayor - $this->segundo_dato_mayor) / ($this->dato_mayor - $this->dato_menor);

        $this->limite_inf = ($this->segundo_dato_menor - $this->dato_menor) / ($this->dato_mayor - $this->dato_menor);



        // // foreach ($array_resultados as $row_result) {

        //     if ($retornar_solo_atipicos == true) {

        //         if (($row_result[$columna] <= $this->limite_inf && $row_result[$columna]==$this->dato_menor)||($row_result[$columna] >= $this->limite_sup && $row_result[$columna]==$this->dato_mayor)) {

        //             array_push($this->new_array_resultados, $row_result);

        //         }



        //     } else {

        //         if((($row_result[$columna] > $this->limite_inf && $row_result[$columna]==$this->dato_menor)||($row_result[$columna] < $this->limite_sup && $row_result[$columna]==$this->dato_mayor))||($row_result[$columna]!=$this->dato_menor && $row_result[$columna]!=$this->dato_mayor)){

        //         array_push($this->new_array_resultados, $row_result);

        //     }

        //     }

        // }





        if ($retornar_solo_atipicos == true) {

            if ($this->factor_dixon_utilizado < $this->limite_inf) {

                array_push($this->new_array_resultados, $array_resultados[0]);

            }

            if ($this->factor_dixon_utilizado < $this->limite_sup) {

                array_push($this->new_array_resultados, $array_resultados[$n - 1]);

            }

        } else {

            foreach ($array_resultados as $row_result) {

                switch ($row_result[$columna]) {

                    case $this->dato_menor:

                        if ($this->factor_dixon_utilizado >= $this->limite_inf) {

                            array_push($this->new_array_resultados, $row_result);

                        }

                        break;

                    case $this->dato_mayor:

                        if ($this->factor_dixon_utilizado >= $this->limite_sup) {

                            array_push($this->new_array_resultados, $row_result);

                        }

                        break;

                    default:

                        array_push($this->new_array_resultados, $row_result);

                        break;



                }

            }

        }

        return $this->new_array_resultados;

    }





    function getPromediosNormales($columna)
    {



        $media = $this->stats_average(array_column($this->new_array_resultados, $columna));

        $de = $this->stats_standard_deviation(array_column($this->new_array_resultados, $columna), true);



        if ($media == 0) {

            $cv = 0;

        } else {

            $cv = (($de / $media) * 100);

        }



        $n = sizeof(array_column($this->new_array_resultados, $columna));



        return [

            "media" => $media,

            "de" => $de,

            "cv" => $cv,

            "n" => $n

        ];

    }



    function stats_standard_deviation(array $a, $sample = true)
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

    public function get_factor_dixon_utilizado()
    {

        if (isset($this->factor_dixon_utilizado)) {

            return round($this->factor_dixon_utilizado, 4);

        }

        return " - - ";

    }



    public function get_limite_inf()
    {

        if (isset($this->limite_inf)) {

            return round($this->limite_inf, 4);

        }

        return " - - ";

    }



    public function get_limite_sup()
    {

        if (isset($this->limite_sup)) {

            return round($this->limite_sup, 4);

        }

        return " - - ";

    }





    public function get_media_general()
    {

        if (isset($this->media_general)) {

            return round($this->media_general, 3);

        }

        return " - - ";

    }

    public function get_desvest_general()
    {

        if (isset($this->desvest_general)) {

            return round($this->desvest_general, 3);

        }

        return " - - ";

    }



}

