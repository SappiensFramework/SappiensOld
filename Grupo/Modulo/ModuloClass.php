<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{
    private $chavePrimaria;
    
    public function __construct()
    {
        $this->chavePrimaria = 'ufCod';
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
            'ufCod' => 'Cód',
            'ufSigla' => 'Sigla',
            'ufNome' => 'Nome',
            'ufDescricao' => 'Descrição'];

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
            'ufIbgeCod',
            'ufDescricao',
            'ufEscolhaSelect', 
            'ufEscolhaVarios[]', 
            'ufEscolhaDois', 
            'ufMarqueUm'
        ];
        
        return $crud->insert('uf', $campos, $objForm);
    }
    
    public function alterar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        
        $campos = [
            'ufSigla',
            'ufNome',
            'ufIbgeCod',
            'ufDescricao', 
            'ufEscolhaSelect', 
            'ufEscolhaVarios[]', 
            'ufEscolhaDois', 
            'ufMarqueUm'
        ];
        
        return $crud->update('uf', $campos, $objForm, $this->chavePrimaria);
    }
    
    public function remover($cod)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        
        return $crud->delete('uf', $cod, $this->chavePrimaria);
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $util = new \Pixel\Crud\CrudUtil();

        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $objetos = $objForm->getObjetos();
        
        //Intervenção para o campo escolha
        $objetos['ufEscolhaVarios[]']->setValor(explode(',', $parametrosSql['ufEscolhaVarios']));
        
        $util->setParametrosForm($objForm, $parametrosSql, $cod);
        
        return $objForm;
    }

}