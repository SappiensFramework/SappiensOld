<?php

namespace Sappiens\Sistema\Grupo;

class GrupoController extends \Zion\Core\Controller
{

    private $grupoClass;
    private $grupoForm;

    public function __construct()
    {
        $this->grupoClass = new \Sappiens\Sistema\Grupo\GrupoClass();
        $this->grupoForm = new \Sappiens\Sistema\Grupo\GrupoForm();
    }

    protected function iniciar()
    {
        $retorno = '';

        try {
            
            $template = new \Pixel\Template\Template();

            new \Zion\Acesso\Acesso('filtrar');
            
            $template->setConteudoScripts($this->grupoForm->getJSEstatico());

            $iBotoes = new \Pixel\Grid\GridBotoes();

            $filtros = new \Pixel\Filtro\FiltroForm();

            $iBotoes->setFiltros($filtros->montaFiltro($this->grupoForm->getFormFiltro()));
            $botoes = $iBotoes->geraBotoes();

            $grid = $this->grupoClass->filtrar($this->grupoForm->getFormFiltro());

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

        return parent::jsonSucesso($this->grupoClass->filtrar($this->grupoForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->grupoForm->getFormManu('cadastrar');

        if ($this->metodoPOST()) {

            $objForm->validar();

            $this->grupoClass->cadastrar($objForm);

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

            $objForm = $this->grupoForm->getFormManu('alterar', $this->postCod());

            $objForm->validar();

            $this->grupoClass->alterar($objForm);

            $retorno = 'true';
        } else {
            
            $selecionados = $this->registrosSelecionados();            

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->grupoClass->setValoresFormManu($cod, $this->grupoForm);
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

        $selecionados = $this->registrosSelecionados();        
        $rSelecionados = \count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

            foreach ($selecionados as $cod) {

                $this->grupoClass->remover($cod);

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

            $objForm = $this->grupoClass->setValoresFormManu($cod, $this->grupoForm);
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }
    
    protected function mudaPosicao()
    {
        new \Zion\Acesso\Acesso('alterar');
        
        $posicao = $this->grupoClass->mudaPosicao(\filter_input(\INPUT_GET, 'grupoCod'), \filter_input(\INPUT_GET, 'maisMenos'));
        
        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $posicao]);
    }
}
