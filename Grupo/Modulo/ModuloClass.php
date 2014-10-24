<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{

    public function getChavePrimaria()
    {
        return 'ufCidadeCod';
    }

    public function getParametrosGrid($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();
        $util = new \Pixel\Crud\CrudUtil();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $util->getParametrosForm($objForm);

        $hiddenParametros = $fil->getHiddenParametros($meusParametros);

        return array_merge($padrao, $meusParametros, $hiddenParametros);
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();
        
        //Setando Parametros
        \Zion\Paginacao\Parametros::setParametros("GET", $this->getParametrosGrid($objForm));
        
        //Grid de Visualização - Configurações
        $grid->setListados(array('ufCidadeCod', 'ufCidadeNome', 'ufCidadeNomeUfNome'));
        $grid->setTitulos(array('cod', 'cidade', 'cidade/UF'));

        //Configurações Fixas da Grid
        $grid->setSql(parent::filtrarSql());
        $grid->setChave($this->getChavePrimaria());
        $grid->setSelecaoMultipla(true);
        $grid->setAlinhamento(array('ufCidadeNomeUfNome' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $con = Conexao::conectar();

        $arquivoUpload = new ArquivoUpload();

        $con->startTransaction();

        $log = new Log();

        $con->executar(parent::cadastrarSql($objForm));

        $artigoCod = $con->ultimoInsertId();

        $log->geraLog($artigoCod);

        $cFG = $objForm->getBufferCFG("FotoAutor");
        $arquivoUpload->sisUpload($cFG, $artigoCod, "Cad", "Imagem");

        $con->stopTransaction();
    }

    public function alterar($objForm)
    {
        $con = Conexao::conectar();

        $arquivoUpload = new ArquivoUpload();

        $con->startTransaction();

        $log = new Log();

        $con->executar(parent::alterarSql($objForm));

        $cFG = $objForm->getBufferCFG("FotoAutor");
        $arquivoUpload->sisUpload($cFG, $objForm->getCampoRetorna('Id'), "Alt", "Imagem");

        $log->geraLog($objForm->get('Id'));

        $con->stopTransaction();
    }

    public function remover($chave, $form)
    {
        $con = Conexao::conectar();

        $arquivoUpload = new ArquivoUpload();

        $log = new Log();

        $con->startTransaction();

        $con->executar(parent::removerSql($chave));

        $cFG = $form->getBufferCFG("FotoAutor");
        $arquivoUpload->removerArquivos($cFG, $chave);

        $log->geraLog($chave);

        $con->stopTransaction();
    }

    public function getValoresFormManu($Id, $metodo, $form)
    {
        $util = new Util();

        $con = Conexao::conectar();

        $form->getFormManu();

        //Extrai Parametros Sql
        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($Id));

        //Define Campos do Fomulário
        $parametrosForm = $util->getParametrosForm($form);

        //Extrai Parametros de Array Para Superglobal
        $util->getParametrosMetodo($parametrosForm, $parametrosSql, $this->getChave(), $metodo);

        //Retorna Campos
        return $form->getFormManu();
    }

}
