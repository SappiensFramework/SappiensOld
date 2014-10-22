<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController extends \Zion\Core\Controller
                $retorno = $template->abreTagAberta('i', array('class' => 'fa fa-warning recD5px')) . $template->fechaTag('i') . 'Oops! Voc� n�o possui permiss�es de acesso a este m�dulo!';
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
