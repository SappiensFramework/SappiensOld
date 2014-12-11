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

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm = $this->pessoaFisicaForm->getFormManu('alterar', \filter_input(INPUT_POST, 'cod'));

            $objForm->validar();

            $this->pessoaFisicaClass->alterar($objForm);

            $retorno = 'true';
            
        } else {

            $selecionados = \filter_input(INPUT_GET, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->pessoaFisicaClass->setValoresFormManu($cod, $this->pessoaFisicaForm);
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
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

}