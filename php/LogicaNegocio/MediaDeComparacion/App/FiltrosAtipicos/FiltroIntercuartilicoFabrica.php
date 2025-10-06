<?php
include_once __DIR__."/../../../../complementos/IntercuartilV2.php";
class FiltroIntercuartilicoFabrica {

    public function crearFiltro()
    {
        return new IntercuartilV2();
    }
}