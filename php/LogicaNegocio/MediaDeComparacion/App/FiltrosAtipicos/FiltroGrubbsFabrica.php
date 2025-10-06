<?php

include_once __DIR__."/../../../../complementos/GrubbsV2.php";
class FiltroGrubbsFabrica {
    public function crearFiltro()
    {
        return new GrubbsV2();
    }
}
