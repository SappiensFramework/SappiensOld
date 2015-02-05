<?php

namespace Sappiens\Sistema\Usuario;

class UsuarioController extends \Zion\Core\Controller
{

    private $usuarioClass;
    private $usuarioForm;

    public function __construct()
    {
        $this->usuarioClass = new \Sappiens\Sistema\Usuario\UsuarioClass();
        $this->usuarioForm = new \Sappiens\Sistema\Usuario\UsuarioForm();
    }

    protected function iniciar()
    {
        $retorno = '';

        try {

            new \Zion\Acesso\Acesso('filtrar');
            
            $template = new \Pixel\Template\Template();            

            $iBotoes = new \Pixel\Grid\GridBotoes();

            $filtros = new \Pixel\Filtro\FiltroForm();

            $iBotoes->setFiltros($filtros->montaFiltro($this->usuarioForm->getFormFiltro()));
            $botoes = $iBotoes->geraBotoes();

            $grid = $this->usuarioClass->filtrar($this->usuarioForm->getFormFiltro());

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

        return parent::jsonSucesso($this->usuarioClass->filtrar($this->usuarioForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->usuarioForm->getFormManu('cadastrar');

        if ($this->metodoPOST()) {

            $objForm->validar();

            $this->usuarioClass->cadastrar($objForm);

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

            $objForm = $this->usuarioForm->getFormManu('alterar', $this->postCod());

            $objForm->validar();

            $this->usuarioClass->alterar($objForm);

            $retorno = 'true';
        } else {

            $selecionados = $this->registrosSelecionados();

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->usuarioClass->setValoresFormManu($cod, $this->usuarioForm);
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

                $this->usuarioClass->remover($cod);

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

            $objForm = $this->usuarioClass->setValoresFormManu($cod, $this->usuarioForm);
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

}
