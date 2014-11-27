<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{

    public $chavePrimaria;
    public $crudUtil;
    public $tabela;
    public $prefixo;
    public $colunas;
    public $colunasGrid;

    public function __construct()
    {
        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = 'uf';
        $this->prefixo = 'uf';
        $this->chavePrimaria = $this->prefixo . 'Cod';

        $this->colunasCrud = [
            $this->prefixo . 'Sigla',
            $this->prefixo . 'Nome',
            $this->prefixo . 'IbgeCod',
            $this->prefixo . 'TextArea',
            $this->prefixo . 'Descricao',
            $this->prefixo . 'EscolhaSelect',
            $this->prefixo . 'ChosenSimples',
            $this->prefixo . 'Chosenmultiplo[]',
            $this->prefixo . 'EscolhaVarios[]',
            $this->prefixo . 'EscolhaDois',
            $this->prefixo . 'MarqueUm'
        ];

        $this->colunasGrid = [
            $this->prefixo . 'Cod' => "Cód",
            $this->prefixo . 'Sigla' => "Sigla",
            $this->prefixo . 'Nome' => "Nome"
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));
        
        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->colunasGrid));
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

        $objetos = $objForm->getObjetos();

        //Intervenção para o campo escolha
        //$objetos['ufEscolhaVarios[]']->setValor(\explode(',', $parametrosSql['ufEscolhaVarios']));

        //Intervenção para o campo chosen
        //$objetos['ufChosenmultiplo[]']->setValor(\explode(',', $parametrosSql['ufChosenmultiplo']));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }

}
