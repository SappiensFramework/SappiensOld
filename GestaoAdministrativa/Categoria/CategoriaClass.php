<?php

namespace Sappiens\GestaoAdministrativa\Categoria;

class CategoriaClass extends CategoriaSql
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

        $this->tabela = 'website_con_cat';
        $this->prefixo = 'websiteConCat';
        $this->chavePrimaria = $this->prefixo . 'Cod';

        $this->colunasCrud = [
            'organogramaCod',
            'websiteDomCod',
            $this->prefixo . '',
            $this->prefixo . 'Status'
        ];

        $this->colunasGrid = [
            $this->prefixo . ''         => "Categoria",
            'websiteDom'                => "Domínio",
            $this->prefixo . 'Status'   => "Status"
        ];
        
        $this->filtroDinamico = [
            $this->prefixo . ''                 => "a",
            'websiteDomCod'                     => "a"
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));
        
        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->substituaPor('websiteConCatStatus', ['A' => 'Ativo', 'I' => 'Inativo']);

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

    public function getDominiosOrganogramaCod($organogramaCod)
    {
        return $this->con->paraArray(parent::getDominiosOrganogramaCod($organogramaCod));
    }

}
