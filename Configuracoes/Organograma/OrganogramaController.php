<?php

namespace Sappiens\Configuracoes\Organograma;

class OrganogramaController extends \Zion\Core\Controller
{

    private $organogramaClass;
    private $organogramaForm;

    public function __construct()
    {
        $this->organogramaClass = new \Sappiens\Configuracoes\Organograma\OrganogramaClass();
        $this->organogramaForm = new \Sappiens\Configuracoes\Organograma\OrganogramaForm();
    } 

    protected function iniciar()
    {
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();
            $template->setConteudoIconeModulo('fa fa-sitemap');
            $template->setConteudoNomeModulo('Definição do organograma');            

            new \Zion\Acesso\Acesso('filtrar');

            $template->setConteudoScripts($this->organogramaForm->getJSEstatico());

            $getBotoes = new \Pixel\Grid\GridBotoes();

            $filtros = new \Pixel\Filtro\FiltroForm();

            $getBotoes->setFiltros($filtros->montaFiltro($this->organogramaForm->getFormFiltro()));
            $botoes = $getBotoes->geraBotoes();

            $grid = $this->organogramaClass->filtrar($this->organogramaForm->getFormFiltro());

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

        return parent::jsonSucesso($this->organogramaClass->filtrar($this->organogramaForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->organogramaForm->getFormManu('cadastrar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm->validar();

            $this->organogramaClass->cadastrar($objForm);

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

            $objForm = $this->organogramaForm->getFormManu('alterar', \filter_input(INPUT_POST, 'cod'));

            $objForm->validar();

            $this->organogramaClass->alterar($objForm);

            $retorno = 'true';
        } else {

            $selecionados = \filter_input(INPUT_GET, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->organogramaClass->setValoresFormManu($cod, $this->organogramaForm);
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

        $selecionados = \filter_input(INPUT_POST, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $rSelecionados = count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            foreach ($selecionados as $cod) {

                $this->organogramaClass->remover($cod);

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
        
        $selecionados = \filter_input(INPUT_GET, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        if (!\is_array($selecionados)) {
            throw new \Exception("Nenhum registro selecionado!");
        }

        $retorno = '';
        foreach ($selecionados as $cod) {

            $objForm = $this->organogramaClass->setValoresFormManu($cod, $this->organogramaForm);
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function imprimirPDF()
    {

        $exportacao = new \Zion\Exportacao\Exportacao();

        $colunas = $this->organogramaClass->colunasGrid;

        $exportacao->setDadosRelatorio('Grupo', 'Modulo', $colunas, $this->organogramaForm->getFormFiltro());

        if($exportacao->getRelatorio('PDF') === false){
            return \json_encode([
                'sucesso' => 'false',
                'retorno' => "Falha ao gerar PDF!"]);
        }

    }

    protected function downloadCSV()
    {

        $exportacao = new \Zion\Exportacao\Exportacao();

        $colunas = $this->organogramaClass->colunasGrid;

        $exportacao->setDadosRelatorio('Grupo', 'Modulo', $colunas, $this->organogramaForm->getFormFiltro());

        if($exportacao->getRelatorio('CSV') === false){
            return \json_encode([
                'sucesso' => 'false',
                'retorno' => "Falha ao gerar CSV!"]);
        }

    }
    
    protected function downloadXLS()
    {

        $exportacao = new \Zion\Exportacao\Exportacao();

        $colunas = $this->organogramaClass->colunasGrid;

        $exportacao->setDadosRelatorio('Grupo', 'Modulo', $colunas, $this->organogramaForm->getFormFiltro());

        if($exportacao->getRelatorio('XLS') === false){
            return \json_encode([
                'sucesso' => 'false',
                'retorno' => "Falha ao gerar XLS!"]);
        }

    }    

    protected function getOrdem()
    {
        //new \Zion\Acesso\Acesso('filtrar');

        $cod = \filter_input(INPUT_GET, 'a');

        return parent::jsonSucesso($this->organogramaClass->getOrdem($cod));
    }

    protected function getOrganogramaClassificacaoCod()
    {
        //new \Zion\Acesso\Acesso('filtrar');
        $form = new \Sappiens\Configuracoes\Organograma\OrganogramaForm();

        sleep(1);

        $cod = \filter_input(INPUT_GET, 'a');

        $param = $this->organogramaClass->getOrganogramaClassificacaoCod($cod);    
        $formManuPhantom = $form->getFormManuPhantom($param, 'organogramaClassificacaoCod');

        $campo  = $formManuPhantom->getFormHtml('organogramaClassificacaoCod');
        $campo .= $formManuPhantom->javaScript()->getLoad(true); 
        return parent::jsonSucesso($campo);
    }    

    //supostamente, não utilizado
    protected function getOrganogramaClassificacaoTipoCod()
    {
        //new \Zion\Acesso\Acesso('filtrar');
        $form = new \Sappiens\Configuracoes\Organograma\OrganogramaForm();

        sleep(1);

        $cod = \filter_input(INPUT_GET, 'a');

        $param = $this->organogramaClass->getOrganogramaClassificacaoTipoCod($cod);    
        $formManuPhantom = $form->getFormManuPhantom($param, 'organogramaClassificacaoCod');

        $campo  = $formManuPhantom->getFormHtml('organogramaClassificacaoCod');
        $campo .= $formManuPhantom->javaScript()->getLoad(true); 
        return parent::jsonSucesso($campo);
    }    

    protected function getOrganogramaClassificacaoByReferencia()
    {
        //new \Zion\Acesso\Acesso('filtrar');
        $form = new \Sappiens\Configuracoes\Organograma\OrganogramaForm();

        sleep(1);

        $cod = \filter_input(INPUT_GET, 'a');

        $param = $this->organogramaClass->getOrganogramaClassificacaoByReferencia($cod);    
        $formManuPhantom = $form->getFormManuPhantom($param, 'organogramaClassificacaoCod');

        $campo  = $formManuPhantom->getFormHtml('organogramaClassificacaoCod');
        $campo .= $formManuPhantom->javaScript()->getLoad(true); 
        return parent::jsonSucesso($campo);
    }     

    protected function getClassificacaoReordenavel()
    {

        //new \Zion\Acesso\Acesso('filtrar');

        $cod = \filter_input(INPUT_GET, 'a');

        return parent::jsonSucesso($this->organogramaClass->getClassificacaoReordenavel($cod));        

    }    

}
