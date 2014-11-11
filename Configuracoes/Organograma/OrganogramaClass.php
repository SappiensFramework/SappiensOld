<?php

namespace Sappiens\Configuracoes\Organograma;

class OrganogramaClass extends OrganogramaSql
{
    
    private $chavePrimaria;
    private $tabela;
    private $precedencia;
    private $colunas;
    private $colunasGrid;
    
    public function __construct()
    {
        $this->tabela           = 'organograma';        
        $this->precedencia      = 'organograma';      
        $this->tabela2          = 'organograma_classificacao';        
        $this->precedencia2     = 'organogramaClassificacao';                
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunas = [
                    $this->precedencia . 'ReferenciaCod',
                    $this->precedencia . 'ClassificacaoCod',
                    $this->precedencia . 'Nome',
                    $this->precedencia . 'Ordem',
                    $this->precedencia . 'Ordenavel',
                    $this->precedencia . 'Status'
        ];
        $this->colunasGrid = [                                                                                   
                    $this->precedencia  . 'ReferenciaCombinado'  => 'Posição combinada',                                  
                    $this->precedencia  . 'Ordem'                => 'Ordem',         
                    $this->precedencia  . 'Nome'                 => 'Organograma',   
                    $this->precedencia2 . 'Nome'                 => 'Classificação', 
                    $this->precedencia  . 'Status'               => 'Status'
        ];                
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
        $grid->setColunas($this->colunasGrid);

        //Configurações Fixas da Grid
        $grid->setSql(parent::filtrarSql($objForm,$this->colunasGrid));
        $grid->setChave($this->chavePrimaria);
        $grid->setSelecaoMultipla(true);
        //$grid->setAlinhamento(array('organogramaOrdem' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        return $crud->insert($this->tabela, $this->colunas, $objForm);
    }
    
    public function alterar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        return $crud->update($this->tabela, $this->colunas, $objForm, $this->chavePrimaria);
    }
    
    public function remover($cod)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        return $crud->delete($this->tabela, $cod, $this->chavePrimaria);
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $util = new \Pixel\Crud\CrudUtil();

        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $util->setParametrosForm($objForm, $parametrosSql, $cod);
        
        return $objForm;
    }

    public function getOrdem($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $param = $con->execLinhaArray(parent::getOrdem($cod, 'referencia'));

        if(strlen($param['ordemAtual']) <= 0) {

            $param = $con->execLinhaArray(parent::getOrdem($cod));
            if(strlen($param['ordemAtual']) <= 0) {
                return 1;
            } else {
                return $param['ordemAtual'] . '.1';
            }

        } else {

            $tam = strlen(strrchr($param['ordemAtual'], '.'));
            $parcial = substr($param['ordemAtual'], 0, -$tam);
            $final = substr(strrchr($param['ordemAtual'], '.'), 1)+1;
            return $parcial . '.' . $final;

        }

    }    

    public function getOrganogramaClassificacaoCod($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        return $con->paraArray(parent::getOrganogramaClassificacaoCod($cod),'valor','chave');

    }    

}