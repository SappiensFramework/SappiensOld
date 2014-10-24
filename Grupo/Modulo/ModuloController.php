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
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();

            new \Zion\Acesso\Acesso('filtrar');
            
            $moduloForm = new \Sappiens\Grupo\Modulo\ModuloForm();

            $template->setConteudoScripts($moduloForm->getJSEstatico());            
            
            $botoes = (new \Pixel\Grid\GridBotoes())->geraBotoes();

            $grid = $this->modulo->filtrar($moduloForm->getModuloFormFiltro());                       
        
            $template->setTooltipForm();
            $template->setConteudoBotoes($botoes);
            $template->setConteudoGrid($grid);

        } catch (\Exception $ex) {
            $retorno = $ex;
        }
        
        $template->setConteudoMain($retorno);

        return $template->getTemplate();
    }

    protected function filtrar()
    {
        new \Zion\Acesso\Acesso('filtrar');
        
        $moduloForm = new \Sappiens\Grupo\Modulo\ModuloForm();
        
        return parent::jsonSucesso($this->modulo->filtrar($moduloForm->getModuloFormFiltro()));
    }

    protected function cadastrar()
    {
        return json_encode(array('sucesso' => 'true', 'retorno' => 'ret'));
    }

}
