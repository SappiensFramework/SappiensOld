<?php

namespace Sappiens\Grupo\Modulo;

class ModuloClass extends ModuloSql
{

    private $chavePrimaria;
    private $crudUtil;

    public function __construct()
    {
        $this->chavePrimaria = 'ufCod';
        $this->crudUtil = new \Pixel\Crud\CrudUtil();
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));

        //Grid - Configurações
        $colunas = [
            'ufCod' => 'Cód',
            'ufSigla' => 'Sigla',
            'ufNome' => 'Nome',
            'ufDescricao' => 'Descrição'];

        $grid->setColunas($colunas);

        //Configurações Fixas da Grid
        $grid->setSql(parent::filtrarSql($objForm, $colunas));
        $grid->setChave($this->chavePrimaria);

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $campos = [
            'ufSigla',
            'ufNome',
            'ufIbgeCod',
            'ufTextArea',
            'ufDescricao',
            'ufEscolhaSelect',
            'ufChosenSimples',
            'ufChosenmultiplo[]',
            'ufEscolhaVarios[]',
            'ufEscolhaDois',
            'ufMarqueUm'
        ];

        return $this->crudUtil->insert('uf', $campos, $objForm);
    }

    public function alterar($objForm)
    {
        $campos = [
            'ufSigla',
            'ufNome',
            'ufIbgeCod',
            'ufTextArea',
            'ufDescricao',
            'ufEscolhaSelect',
            'ufChosenSimples',
            'ufChosenmultiplo[]',
            'ufEscolhaVarios[]',
            'ufEscolhaDois',
            'ufMarqueUm'
        ];

        return $this->crudUtil->update('uf', $campos, $objForm, $this->chavePrimaria);
    }

    public function remover($cod)
    {
        return $this->crudUtil->delete('uf', $cod, $this->chavePrimaria);
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $objetos = $objForm->getObjetos();

        //Intervenção para o campo escolha
        $objetos['ufEscolhaVarios[]']->setValor(explode(',', $parametrosSql['ufEscolhaVarios']));

        //Intervenção para o campo chosen
        $objetos['ufChosenmultiplo[]']->setValor(explode(',', $parametrosSql['ufChosenmultiplo']));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }

}
