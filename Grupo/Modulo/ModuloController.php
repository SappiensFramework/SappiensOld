<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController extends \Zion\Core\Controller
{
    protected function iniciar()
    {
        $class = new \Sappiens\Grupo\Modulo\ModuloClass();
        
        $template = new \Sappiens\Includes\Template();
        
        $template->setConteudo($class->grid());
        
        $retorno = $template->getTemplate();
                
        return json_encode(array('sucesso' => 'true', 'retorno' => $retorno));
    }

    protected function cadastrar()
    {
        return json_encode(array('sucesso' => 'true', 'retorno' => 'ret'));
    }
}
