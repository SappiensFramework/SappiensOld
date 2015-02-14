<?php

namespace Sappiens\Sistema\AcaoModulo;

class AcaoModuloClass extends AcaoModuloSql
{

    private $chavePrimaria;
    private $crudUtil;
    private $tabela;
    private $colunasCrud;

    public function __construct()
    {
        parent::__construct();

        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = '_acao_modulo';
        $this->chavePrimaria = 'acaoModuloCod';

        $this->colunasCrud = [
            'acaoModuloCod',
            'perfilCod'
        ];
    }

    public function cadastrar($objForm)
    {
        return $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
    }

    public function alterar($objForm)
    {
        return $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, [$this->chavePrimaria => $objForm->get('cod')]);
    }

    public function remover($cod)
    {
        return $this->crudUtil->delete($this->tabela, $cod, [$this->chavePrimaria => $cod]);
    }
}
