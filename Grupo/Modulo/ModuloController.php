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

            $filtros = $filtro->montaFiltro($this->moduloForm->getModuloFormFiltro());

            $botoes = (new \Pixel\Grid\GridBotoes())->geraBotoes('');

            $grid = $this->moduloClass->filtrar($this->moduloForm->getModuloFormFiltro());

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

        return parent::jsonSucesso($this->moduloClass->filtrar($this->moduloForm->getModuloFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {

            $this->moduloClass->cadastrar($this->moduloForm->getModuloForm());

            $retorno = 'true';
        } else {

            $objForm = $this->moduloForm->getModuloForm();
            $retorno = $objForm->montaForm();
        }

        return \json_encode(['sucesso' => 'true', 'retorno' => $retorno]);
    }

}
