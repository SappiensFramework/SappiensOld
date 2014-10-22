<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController extends \Zion\Core\Controller
{

    protected function iniciar()
    {
        try {

            $template = new \Pixel\Template\Template();

            $acesso = new \Zion\Acesso\Acesso();

            $modulo = new \Sappiens\Grupo\Modulo\ModuloClass();

            if ($acesso->permissaoAcao('filtrar')) {
                $retorno = $modulo->filtrar();
            } else {
                $retorno = $template->abreTagAberta('i', array('class' => 'fa fa-warning recD5px')) . $template->fechaTag('i') . 'Oops! Você não possui permissões de acesso a este módulo!';
            }
        } catch (\Exception $ex) {
            $retorno = $ex;
        }

        $template->setConteudoMain($retorno);

        return $template->getTemplate();
    }

    protected function filtrar()
    {
        new \Zion\Acesso\Acesso('filtrar');

        $modulo = new \Sappiens\Grupo\Modulo\ModuloClass();

        return parent::jsonSucesso($modulo->grid());
    }

    protected function cadastrar()
    {
        return json_encode(array('sucesso' => 'true', 'retorno' => 'ret'));
    }

}
