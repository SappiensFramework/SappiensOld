<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass
{

    public function getChave()
    {
        return "ArtigoCod";
    }

    public function getParametros($ObjForm)
    {
        $Fil = new Filtrar();
        $Util = new Util();

        $Padrao = array("PaginaAtual", "QuemOrdena", "TipoOrdenacao");

        $MeusParametros = $Util->getParametrosForm($ObjForm);

        $HiddenParametros = $Fil->getHiddenParametros($MeusParametros);

        return array_merge($Padrao, $MeusParametros, $HiddenParametros);
    }

    public function grid()
    {
        return '<table style="width:100%"><tr><td>Jill</td><td>Smith</td> 
        <td>50</td></tr><tr><td>Eve</td><td>Jackson</td><td>94</td></tr></table>';
    }

    public function visualizar()
    {
        $Gr = new GridVisualizar();

        //Grid de Visualiza? Detalhada
        $Gr->setListados(array("ArtigoCod", "ArtigoAutor", "ArtigoTitulo", "ArtigoConteudo", "ArtigoData", "Criado"));
        $Gr->setTitulos(array("Cód", "Autor", "Titulo", "Texto", "Data", "Criado"));

        //Configura?s Fixas da Grid
        $Gr->setChave($this->getChave());

        //Retornando a Grid Formatada - HTML
        if (!is_array($_POST['SisReg']))
            throw new Exception("Nenhum registro selecionado!");

        foreach ($_POST['SisReg'] as $Cod) {
            $Gr->setSql(parent::visualizarSql($Cod));
            $Vis .= $Gr->montaGridVisualizar();
        }

        return $Vis;
    }

    public function cadastrar($ObjForm)
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
        $Con->executar(parent::cadastrarSql($ObjForm));

        //Código Gerado
        $ArtigoCod = $Con->ultimoInsertId();

        //Grava Log
        $Log->geraLog($ArtigoCod);

        $CFG = $ObjForm->getBufferCFG("FotoAutor");
        $ArquivoUpload->sisUpload($CFG, $ArtigoCod, "Cad", "Imagem");

        //Finaliza Transação
        $Con->stopTransaction();
    }

    public function alterar($ObjForm)
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
        $Con->executar(parent::alterarSql($ObjForm));

        $CFG = $ObjForm->getBufferCFG("FotoAutor");
        $ArquivoUpload->sisUpload($CFG, $ObjForm->getCampoRetorna('Id'), "Alt", "Imagem");

        //Grava Log
        $Log->geraLog($ObjForm->get('Id'));

        //Finaliza Transação
        $Con->stopTransaction();
    }

    public function remover($Chave, $Form)
    {
        $Con = Conexao::conectar();

        //Classe de Upload
        $ArquivoUpload = new ArquivoUpload();

        $Log = new Log();

        $Con->startTransaction();

        $Con->executar(parent::removerSql($Chave));

        $CFG = $Form->getBufferCFG("FotoAutor");
        $ArquivoUpload->removerArquivos($CFG, $Chave);

        $Log->geraLog($Chave);

        $Con->stopTransaction();
    }

    public function getValoresFormManu($Id, $Metodo, $Form)
    {
        //Processador de Formulários
        $Util = new Util();

        //Inicia Conexão
        $Con = Conexao::conectar();

        //Executa Formulário de Manutenção apenas para obtenção de configurações
        $Form->setProcessarHtml(false);
        $Form->setProcessarValidacao(false);
        $Form->getFormManu();

        //Extrai Parametros Sql
        $ParametrosSql = $Con->execLinhaArray(parent::getDadosSql($Id));

        //Define Campos do Fomulário
        $ParametrosForm = $Util->getParametrosForm($Form);

        //Extrai Parametros de Array Para Superglobal
        $Util->getParametrosMetodo($ParametrosForm, $ParametrosSql, $this->getChave(), $Metodo);

        //Processamento apenas HTML - Ativa Validação e HTML
        $Form->setProcessarHtml(true);
        $Form->setProcessarValidacao(true);

        //Retorna Campos
        return $Form->getFormManu();
    }

}
