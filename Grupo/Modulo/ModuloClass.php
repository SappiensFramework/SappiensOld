<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{
    private $chavePrimaria;
    
    public function __construct()
    {
        $this->chavePrimaria = 'ufCidadeCod';
    }

    public function getParametrosGrid($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();
        $crud = new \Pixel\Crud\CrudUtil();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $crud->getParametrosForm($objForm);

        $hiddenParametros = $fil->getHiddenParametros($meusParametros);

        return array_merge($padrao, $meusParametros, $hiddenParametros);
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        //Setando Parametros
        \Zion\Paginacao\Parametros::setParametros("GET", $this->getParametrosGrid($objForm));

        //Grid de Visualização - Configurações
        $colunas = [
            'ufCidadeCod' => 'Cód',
            'ufCidadeNome' => 'Cidade',
            'ufCidadeNomeUfNome' => 'Cidade/Uf'];

        $grid->setColunas($colunas);

        //Configurações Fixas da Grid
        $grid->setSql(parent::filtrarSql($objForm,$colunas));
        $grid->setChave($this->chavePrimaria);
        $grid->setSelecaoMultipla(true);
        $grid->setAlinhamento(array('ufCidadeNomeUfNome' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        
        $campos = [
            'ufSigla',
            'ufNome',
            'ufIbgeCod'
        ];
        
        return $crud->insert('uf', $campos, $objForm);
    }
    
    public function alterar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        
        $campos = [
            'ufSigla',
            'ufNome',
            'ufIbgeCod'
        ];
        
        return $crud->update('uf', $campos, $objForm, $this->chavePrimaria);
    }
    
    
    public function alterarOld($objForm)
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

    public function getValoresFormManu($cod, $metodo, $form)
    {
        $util = new \Pixel\Crud\CrudUtil();

        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $form->getFormManu('alterar');

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        //Define Campos do Fomulário
        $parametrosForm = $util->getParametrosForm($objForm);

        //Extrai Parametros de Array Para Superglobal
        $util->getParametrosMetodo($parametrosForm, $parametrosSql, $this->chavePrimaria, $metodo);

        //Retorna Campos
        return $form->getFormManu('alterar');
    }

}
