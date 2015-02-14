<?php

namespace Sappiens\Sistema\Perfil;

class PerfilController extends \Zion\Core\Controller
{

    private $usuarioClass;
    private $usuarioForm;

    public function __construct()
    {
        $this->usuarioClass = new \Sappiens\Sistema\Perfil\PerfilClass();
        $this->usuarioForm = new \Sappiens\Sistema\Perfil\PerfilForm();
    }

    protected function iniciar()
    {
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();

            new \Zion\Acesso\Acesso('filtrar');

            $template->setConteudoScripts($this->usuarioForm->getJSEstatico());
            $conteudo = '<style type="text/css">.iten-com-checkbox div { padding:8px; }.iten-com-checkbox {margin-top:-4px;}.iten-com-checkbox:hover {background:#f5f5f5 !important; cursor:pointer;}.list-no-style .iten-com-checkbox:nth-child(even) {border-bottom:1px solid #f5f5f5; border-top:1px solid #f5f5f5; background:#fbfbfb;}.list-no-style .checkbox-inline {padding-top:0px;}.list-no-style li {width: 100%; display: inline-block !important;}.list-no-style {-webkit-user-select: none; -ms-user-select: none; -o-user-select: none; user-select: none; -moz-user-select: none; }#sisContainerManu div .panel .panel-body {display:none;}.displaytable{display:table; width:100%;}.list-no-style{margin-bottom:0px; list-style:none;padding-left:20px}.list-no-style li strong{display:block;margin-left:11px;border-bottom:1px solid #e9e9e9;padding:5px 0}.list-no-style ::selected{background-color:#fff}.panel-title{cursor:pointer}.permissoes-usuario-todos button{position:relative}.permissoes-usuario-todos .labels{background-color:transparent;padding-left:5px;margin-left:0;line-height:0;font-size:10px;font-weight:700}.list-no-style label{margin-left:9px}.acoes-marcar{margin-top:-3.5px;display:table;float:right}.marca{margin-left:30px}.desmarca{margin-left:5px}</style>';
            $template->setConteudoHeader($conteudo);

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

            $objForm = $this->usuarioClass->setValoresFormManu($cod, $this->usuarioForm, 'visualizar');
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

}
