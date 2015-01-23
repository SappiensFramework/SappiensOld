<?php

namespace Sappiens\GestaoAdministrativa\Conteudo;

class ConteudoClass extends ConteudoSql
{

    public $chavePrimaria;
    public $crudUtil;
    public $tabela;
    public $prefixo;
    private $colunasCrud;
    private $colunasGrid;
    private $filtroDinamico;
    protected $con;

    public function __construct()
    {
        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->con = \Zion\Banco\Conexao::conectar();

        $this->tabela = 'website_con';
        $this->prefixo = 'websiteCon';
        $this->chavePrimaria = $this->prefixo . 'Cod';

        $this->colunasCrud = [
            'organogramaCod',
            'websiteDomCod',
            $this->prefixo . '',
            $this->prefixo . 'CatCod',
            $this->prefixo . 'ReferenteCod',
            $this->prefixo . 'Titulo',
            $this->prefixo . 'Descricao',
            $this->prefixo . 'Data',
            $this->prefixo . 'Prioridade',
            $this->prefixo . 'Status'
        ];

        $this->colunasGrid = [
            $this->prefixo . 'Titulo'   => "Título",
            $this->prefixo . 'Cat'      => "Categoria",
            $this->prefixo . 'Data'     => "Data"
        ];
        
        $this->filtroDinamico = [
            $this->prefixo . ''             => 'a',
            $this->prefixo . 'Cat'          => 'b',
            $this->prefixo . 'Titulo'       => 'a',
            $this->prefixo . 'Descricao'    => 'a',
            $this->prefixo . 'Data'         => 'a',
            'websiteDomCod'                 => 'a',
            'websiteDomCod'                 => 'b',
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));
        
        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        return $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
    }

    public function alterar($objForm)
    {
        return $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, $this->chavePrimaria);
    }

    public function remover($cod)
    {
        return $this->crudUtil->delete($this->tabela, $cod, $this->chavePrimaria);
    }

    public function setValoresFormManu($cod, $formInstancia)
    {
        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formInstancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));
//print_r($parametrosSql);
        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }
   
    public function getDados($dominioCod)
    {
        return $this->con->paraArray(parent::getDadosSql($dominioCod));
    }
    
    public function getDominiosOrganogramaCod($organogramaCod)
    {
        return $this->con->paraArray(parent::getDominiosOrganogramaCod($organogramaCod));
    }
    
    public function getCategoriasWebsiteDomCod($websiteDomCod)
    {
        return $this->con->paraArray(parent::getCategoriasWebsiteDomCod($websiteDomCod));
    }
    
    public function getConteudoReferenteCod($websiteConCatCod)
    {
        return $this->con->paraArray(parent::getConteudoReferenteCod($websiteConCatCod));
    }
}
