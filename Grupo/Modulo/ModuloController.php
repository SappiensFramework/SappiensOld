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
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();

            new \Zion\Acesso\Acesso('filtrar');

            $template->setConteudoScripts($this->moduloForm->getJSEstatico());

            $getBotoes = new \Pixel\Grid\GridBotoes();

            $filtros = new \Pixel\Filtro\FiltroForm();

            $getBotoes->setFiltros($filtros->montaFiltro($this->moduloForm->getFormFiltro()));
            $botoes = $getBotoes->geraBotoes();

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

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function alterar()
    {
        new \Zion\Acesso\Acesso('alterar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm = $this->moduloForm->getFormManu('alterar', \filter_input(\INPUT_POST, 'cod'));

            $objForm->validar();

            $this->moduloClass->alterar($objForm);

            $retorno = 'true';
        } else {

            $selecionados = \filter_input(\INPUT_GET, 'sisReg', \FILTER_DEFAULT, \FILTER_REQUIRE_ARRAY);

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->moduloClass->setValoresFormManu($cod, $this->moduloForm);
                $retorno .= $objForm->montaForm();
                $retorno .= $objForm->javaScript()->getLoad(true);
                $objForm->javaScript()->resetLoad();
            }
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function remover()
    {
        new \Zion\Acesso\Acesso('remover');

        $selecionados = \filter_input(\INPUT_POST, 'sisReg', \FILTER_DEFAULT, \FILTER_REQUIRE_ARRAY);
        $rSelecionados = \count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            foreach ($selecionados as $cod) {

                $this->moduloClass->remover($cod);

                $rApagados++;
            }
        } catch (\Exception $ex) {

            $mensagem[] = $ex->getMessage();
        }

        return \json_encode([
            'sucesso' => 'true',
            'selecionados' => $rSelecionados,
            'apagados' => $rApagados,
            'retorno' => \implode("\\n", $mensagem)]);
    }
    
    protected function visualizar()
    {
        new \Zion\Acesso\Acesso('visualizar');
        
        $selecionados = \filter_input(\INPUT_GET, 'sisReg', \FILTER_DEFAULT, \FILTER_REQUIRE_ARRAY);

        if (!\is_array($selecionados)) {
            throw new \Exception("Nenhum registro selecionado!");
        }

        $retorno = '';
        foreach ($selecionados as $cod) {

            $objForm = $this->moduloClass->setValoresFormManu($cod, $this->moduloForm);
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function imprimirPDF()
    {

        $exportacao = new \Zion\Exportacao\Exportacao();

        $colunas = $this->moduloClass->colunasGrid;

        $exportacao->setDadosRelatorio('Grupo', 'Modulo', $colunas, $this->moduloForm->getFormFiltro());

        if($exportacao->getRelatorio('PDF') === false){
            return \json_encode([
                'sucesso' => 'false',
                'retorno' => "Falha ao gerar PDF!"]);
        }

    }

    protected function downloadCSV()
    {

        $exportacao = new \Zion\Exportacao\Exportacao();

        $colunas = $this->moduloClass->colunasGrid;

        $exportacao->setDadosRelatorio('Grupo', 'Modulo', $colunas, $this->moduloForm->getFormFiltro());

        if($exportacao->getRelatorio('CSV') === false){
            return \json_encode([
                'sucesso' => 'false',
                'retorno' => "Falha ao gerar CSV!"]);
        }

    }
    
    protected function downloadXLS()
    {

        $exportacao = new \Zion\Exportacao\Exportacao();

        $colunas = $this->moduloClass->colunasGrid;

        $exportacao->setDadosRelatorio('Grupo', 'Modulo', $colunas, $this->moduloForm->getFormFiltro());

        if($exportacao->getRelatorio('XLS') === false){
            return \json_encode([
                'sucesso' => 'false',
                'retorno' => "Falha ao gerar XLS!"]);
        }

    }

}
