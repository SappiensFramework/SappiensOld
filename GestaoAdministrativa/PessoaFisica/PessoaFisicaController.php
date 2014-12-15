<?php

namespace Sappiens\GestaoAdministrativa\PessoaFisica;

class PessoaFisicaController extends \Zion\Core\Controller
{

    private $pessoaFisicaClass;
    private $pessoaFisicaForm;

    public function __construct()
    {
        $this->pessoaFisicaClass = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaClass();
        $this->pessoaFisicaForm = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaForm();
    }

    protected function iniciar()
    {
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();
            $template->setConteudoIconeModulo('fa fa-user');
            $template->setConteudoNomeModulo('Pessoa física');            

            new \Zion\Acesso\Acesso('filtrar');

            $template->setConteudoScripts($this->pessoaFisicaForm->getJSEstatico());

            $getBotoes = new \Pixel\Grid\GridBotoes();

            $getBotoes->setFiltros('');
            $botoes = $getBotoes->geraBotoes();

            $grid = $this->pessoaFisicaClass->filtrar($this->pessoaFisicaForm->getFormFiltro());

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

        return parent::jsonSucesso($this->pessoaFisicaClass->filtrar($this->pessoaFisicaForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->pessoaFisicaForm->getFormManu('cadastrar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm->validar();
            $this->pessoaFisicaClass->cadastrar($objForm);
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

            $codForm = $this->postCod();
            $cod = \filter_input(INPUT_POST, 'pessoaDocumentoTipoCod');

            switch (\filter_input(INPUT_POST, 'n')) {

                case 'inicial':
                    
                    $objForm = $this->pessoaFisicaForm->getFormManu('alterar', $this->postCod());
                    $objForm->validar();
                    $this->pessoaFisicaClass->alterar($objForm);

                break;

                case 'documento':

                    $objFormHtml = $this->pessoaFisicaForm->getFormManuDocumento('alterar', $this->postCod());
                    $objFormHtml->validar();                    

                    $param = $this->pessoaFisicaClass->getCampos($cod);    
                    $objFormDinamico = $this->pessoaFisicaForm->getObjetoCampos($param, $cod, $codForm);
                    //print_r($objFormDinamico);

                    $objFormDinamico->validar();
                    //$this->pessoaFisicaClass->alterarDocumento($objFormHtml); 

                    $resultCampos = $this->pessoaFisicaClass->getCampos($cod);    
                    $objForm = $this->pessoaFisicaForm->getObjetoCampos($resultCampos, $cod, $codForm);
                    $objForm->validar();

                    $this->pessoaFisicaClass->alterarDocumento($objForm);                    
                
                break;

            }

            $retorno = 'true';
            
        } else {

            $selecionados = $this->registrosSelecionados();            

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            $retorno = '';
            foreach ($selecionados as $cod) {
                
                $retorno = $this->emTabs($cod,
                        $this->pessoaFisicaClass->setValoresFormManu($cod, $this->pessoaFisicaForm),
                        $this->pessoaFisicaClass->setValoresFormManuDocumento($cod, $this->pessoaFisicaForm),
                        $this->pessoaFisicaClass->setValoresFormManuContato($cod, $this->pessoaFisicaForm));
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

                $this->pessoaFisicaClass->remover($cod);

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

            $objForm = $this->pessoaFisicaClass->setValoresFormManu($cod, $this->pessoaFisicaForm);
            $retorno = $this->emTabs($cod,
                    $this->pessoaFisicaClass->setValoresFormManu($cod, $this->pessoaFisicaForm),
                    $this->pessoaFisicaClass->setValoresFormManuDocumento($cod, $this->pessoaFisicaForm),
                    $this->pessoaFisicaClass->setValoresFormManuContato($cod, $this->pessoaFisicaForm));
            //$retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function getCamposDocumentos()
    {

        $form = '';
        $param = '';
        $cod = \filter_input(INPUT_GET, 'a');
        $codForm = \filter_input(INPUT_GET, 'd');

        $param = $this->pessoaFisicaClass->getCampos($cod);    
        $form = $this->pessoaFisicaForm->getFormCampos($param, $cod, $codForm);

        return parent::jsonSucesso($form);

    }

}
