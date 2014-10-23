<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{

    public function getChavePrimaria()
    {
        return "ArtigoCod";
    }

    public function getParametros($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();
        $util = new \Zion\Crud\CrudUtil();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $util->getParametrosForm($objForm);

        $hiddenParametros = $fil->getHiddenParametros($meusParametros);

        return array_merge($padrao, $meusParametros, $hiddenParametros);
    }

    public function filtrar()
    {
        $grid = new \Pixel\Grid\GridPadrao();

        //Grid de Visualização - Configurações
        $grid->setListados(array("UfCidadeCod", "UfCidadeNome", "UfCidadeNomeUfNome"));
        $grid->setTitulos(array("Cod", "Cidade", "Cidade/UF"));

        //Setando Parametros
        \Zion\Paginacao\Parametros::setParametros("GET", array());


        //Configurações Fixas da Grid
        $grid->setSql(parent::filtrarSql());
        $grid->setChave('UfCidadeCod');
        $grid->setSelecaoMultipla(true);
        $grid->setAlinhamento(array('UfCidadeNomeUfNome' => 'DIREITA'));
        //$grid->setSelecao(false);
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        //Retornando a Grid Formatada - HTML
        return $grid->montaGridPadrao();
    }

    public function visualizar()
    {
        $grid = new GridVisualizar();

        //Grid de Visualiza? Detalhada
        $grid->setListados(array("ArtigoCod", "ArtigoAutor", "ArtigoTitulo", "ArtigoConteudo", "ArtigoData", "Criado"));
        $grid->setTitulos(array("Cód", "Autor", "Titulo", "Texto", "Data", "Criado"));

        //Configura?s Fixas da Grid
        $grid->setChave($this->getChave());

        //Retornando a Grid Formatada - HTML
        if (!is_array($_POST['SisReg']))
            throw new Exception("Nenhum registro selecionado!");

        foreach ($_POST['SisReg'] as $Cod) {
            $grid->setSql(parent::visualizarSql($Cod));
            $Vis .= $grid->montaGridVisualizar();
        }

        return $Vis;
    }

    public function cadastrar($objForm)
    {
        //Inicia Conexão
        $Con = Conexao::conectar();

        //Classe de Upload
        $ArquivoUpload = new ArquivoUpload();

        //Inicia Transação
        $Con->startTransaction();

        //Inicia Classe de Logs
        $Log = new Log();

        //Executa Sql
        $Con->executar(parent::cadastrarSql($objForm));

        //Código Gerado
        $ArtigoCod = $Con->ultimoInsertId();

        //Grava Log
        $Log->geraLog($ArtigoCod);

        $CFG = $objForm->getBufferCFG("FotoAutor");
        $ArquivoUpload->sisUpload($CFG, $ArtigoCod, "Cad", "Imagem");

        //Finaliza Transação
        $Con->stopTransaction();
    }

    public function alterar($objForm)
    {
        //Inicia Conexão
        $Con = Conexao::conectar();

        //Classe de Upload
        $ArquivoUpload = new ArquivoUpload();

        //Inicia Transação
        $Con->startTransaction();

        //Inicia Classe de Logs
        $Log = new Log();

        //Executa Sql
        $Con->executar(parent::alterarSql($objForm));

        $CFG = $objForm->getBufferCFG("FotoAutor");
        $ArquivoUpload->sisUpload($CFG, $objForm->getCampoRetorna('Id'), "Alt", "Imagem");

        //Grava Log
        $Log->geraLog($objForm->get('Id'));

        //Finaliza Transação
        $Con->stopTransaction();
    }

    public function remover($Chave, $form)
    {
        $Con = Conexao::conectar();

        //Classe de Upload
        $ArquivoUpload = new ArquivoUpload();

        $Log = new Log();

        $Con->startTransaction();

        $Con->executar(parent::removerSql($Chave));

        $CFG = $form->getBufferCFG("FotoAutor");
        $ArquivoUpload->removerArquivos($CFG, $Chave);

        $Log->geraLog($Chave);

        $Con->stopTransaction();
    }

    public function getValoresFormManu($Id, $metodo, $form)
    {
        //Processador de Formulários
        $Util = new Util();

        //Inicia Conexão
        $Con = Conexao::conectar();

        //Executa Formulário de Manutenção apenas para obtenção de configurações
        $form->setProcessarHtml(false);
        $form->setProcessarValidacao(false);
        $form->getFormManu();

        //Extrai Parametros Sql
        $parametrosSql = $Con->execLinhaArray(parent::getDadosSql($Id));

        //Define Campos do Fomulário
        $parametrosForm = $Util->getParametrosForm($form);

        //Extrai Parametros de Array Para Superglobal
        $Util->getParametrosMetodo($parametrosForm, $parametrosSql, $this->getChave(), $metodo);

        //Processamento apenas HTML - Ativa Validação e HTML
        $form->setProcessarHtml(true);
        $form->setProcessarValidacao(true);

        //Retorna Campos
        return $form->getFormManu();
    }

}
