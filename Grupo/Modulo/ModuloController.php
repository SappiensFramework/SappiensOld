<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController extends \Zion\Core\Controller
{   
    protected function filtrar()
    {
        $modulo = new \Sappiens\Grupo\Modulo\ModuloClass();

        return parent::jsonSucesso($modulo->filtrar());
    }

    protected function cadastrar()
    {
        return json_encode(array('sucesso' => 'true', 'retorno' => 'ret'));
    }

}
