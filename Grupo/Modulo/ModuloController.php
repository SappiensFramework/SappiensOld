<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController extends \Zion\Core\Controller
{
    private $modulo;
    
    public function __construct()
    {
        $this->modulo = new \Sappiens\Grupo\Modulo\ModuloClass();
    }

    protected function iniciar()
    {
        $botoes = '';
        $grid = '';
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();

            $acesso = new \Zion\Acesso\Acesso();

            $moduloForm = new \Sappiens\Grupo\Modulo\ModuloForm();

            $template->setConteudoScripts($moduloForm->getJSEstatico());

            if ($acesso->permissaoAcao('filtrar')) {

                $botoes = (new \Pixel\Grid\GridBotoes())->geraBotoes();

                $grid = $this->modulo->filtrar($moduloForm->getModuloFormFiltro());
            } else {
                $retorno = 'Sem permissão';
            }
        } catch (\Exception $ex) {
            $retorno = $ex;
        }

        $template->setTooltipForm();
        $template->setConteudoBotoes($botoes);
        $template->setConteudoGrid($grid);
        $template->setConteudoMain($retorno);

        return $template->getTemplate();
    }

    protected function filtrar()
    {
        $moduloForm = new \Sappiens\Grupo\Modulo\ModuloForm();
        
        return parent::jsonSucesso($this->modulo->filtrar($moduloForm->getModuloFormFiltro()));
    }

    protected function cadastrar()
    {
        return json_encode(array('sucesso' => 'true', 'retorno' => 'ret'));
    }

}
