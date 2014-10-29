<?php

namespace Sappiens\Grupo\Modulo;

class ModuloController extends \Zion\Core\Controller
{

    private $moduloClass;
    private $moduloForm;

    public function __construct()
    {
        $this->moduloClass = new \Sappiens\Grupo\Modulo\ModuloClass();
        $this->moduloForm = new \Sappiens\Grupo\Modulo\ModuloForm();
    }

    protected function iniciar()
    {
        $filtro = new \Pixel\Filtro\FiltroForm();

        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();

            new \Zion\Acesso\Acesso('filtrar');

            $template->setConteudoScripts($this->moduloForm->getJSEstatico());

            $filtros = $filtro->montaFiltro($this->moduloForm->getFormFiltro());

            $botoes = (new \Pixel\Grid\GridBotoes())->geraBotoes('');

            $grid = $this->moduloClass->filtrar($this->moduloForm->getFormFiltro());

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

        return parent::jsonSucesso($this->moduloClass->filtrar($this->moduloForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->moduloForm->getFormManu('cadastrar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm->validar();
            
            $this->moduloClass->cadastrar($objForm);

            $retorno = 'true';
        } else {

            $retorno = $objForm->montaForm();
            $retorno.= $objForm->javaScript()->getLoad(true);
        }

        return \json_encode(['sucesso' => 'true', 'retorno' => $retorno]);
    }
    
    protected function alterar()
    {
        new \Zion\Acesso\Acesso('alterar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm = $this->moduloForm->getFormManu('alterar');
            
            $objForm->validar();
            
            $this->moduloClass->alterar($objForm);

            $retorno = 'true';
        } else {

            $selecionados = \filter_input(INPUT_GET, 'sisReg',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            if(!\is_array($selecionados)){
                throw new \Exception("Nenhum registro selecionado!");
            }
            
            $retorno = '';
            foreach ($selecionados as $cod){
            
                $objForm = $this->moduloClass->setValoresFormManu($cod, $this->moduloForm);
                $retorno .= $objForm->montaForm();                
            }
            
            $retorno .= $objForm->javaScript()->getLoad(true);
        }

        return \json_encode(['sucesso' => 'true', 'retorno' => $retorno]);
    }

}
