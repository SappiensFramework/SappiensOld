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

        if ($this->metodoPOST()) {

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

        if ($this->metodoPOST()) {

            $objForm = $this->moduloForm->getFormManu('alterar', $this->postCod());

            $objForm->validar();

            $this->moduloClass->alterar($objForm);

            $retorno = 'true';
        } else {
            
            $selecionados = $this->registrosSelecionados();            

            $retorno = '';
            foreach ($selecionados as $cod) {
                
                $retorno = $this->emTabs($cod,
                        $this->moduloClass->setValoresFormManu($cod, $this->moduloForm),
                        $this->moduloClass->setValoresFormManu2($cod, $this->moduloForm));
            }
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function remover()
    {
        new \Zion\Acesso\Acesso('remover');

        $selecionados = $this->registrosSelecionados();
        $rSelecionados = \count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

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
        
        $selecionados = $this->registrosSelecionados();

        $retorno = '';
        foreach ($selecionados as $cod) {

            $objForm = $this->moduloClass->setValoresFormManu($cod, $this->moduloForm);
            //$retorno .= $objForm->montaFormVisualizar();
            $retorno = $this->emTabs($cod,
                    $this->moduloClass->setValoresFormManu($cod, $this->moduloForm),
                    $this->moduloClass->setValoresFormManu2($cod, $this->moduloForm));            
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
