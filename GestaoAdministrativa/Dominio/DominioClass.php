<?php

namespace Sappiens\GestaoAdministrativa\Dominio;

class DominioClass extends DominioSql
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

        $this->tabela = 'website_dom';
        $this->prefixo = 'websiteDom';
        $this->chavePrimaria = $this->prefixo . 'Cod';

        $this->colunasCrud = [
            'organogramaCod',
            $this->prefixo . '',
            $this->prefixo . 'Email',
            $this->prefixo . 'NomeAbreviado',
            $this->prefixo . 'NomeExtenso',
            $this->prefixo . 'Descricao',
            $this->prefixo . 'PalavrasChave',
            $this->prefixo . 'Publicar',
            $this->prefixo . 'Status'
        ];

        $this->colunasGrid = [
            $this->prefixo . ''                 => "Domínio",
            $this->prefixo . 'Email'            => "Email",
            $this->prefixo . 'NomeAbreviado'    => "Nome"
        ];
        
        $this->filtroDinamico = [
            $this->prefixo . ''                 => "",
            $this->prefixo . 'Email'            => "",
            $this->prefixo . 'NomeAbreviado'    => "",
            $this->prefixo . 'PalavrasChave'    => ""
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

    public function setValoresFormManu($cod, $formIntancia)
    {
        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }
   
    public function getDados($dominioCod)
    {
        return $this->con->paraArray(parent::getDadosSql($dominioCod));
    }

}
