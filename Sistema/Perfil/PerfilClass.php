<?php

namespace Sappiens\Sistema\Perfil;

class PerfilClass extends PerfilSql
{

    private $chavePrimaria;
    private $crudUtil;
    private $tabela;
    private $colunasCrud;
    private $colunasGrid;
    private $filtroDinamico;

    public function __construct()
    {
        parent::__construct();

        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = '_perfil';
        $this->chavePrimaria = 'perfilCod';

        $this->colunasCrud = [
            'perfilNome',
            'perfilDescricao'
        ];

        $this->colunasGrid = [
            'perfilNome' => 'Perfil',
            'perfilDescricao' => 'Descrição'
        ];

        $this->filtroDinamico = [
            'perfilNome' => '',
            'perfilDescricao' => ''
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));

        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->substituaPor('perfilDescricao', ['<i>nenhuma informação</i>']);

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $permissao = new \Sappiens\Sistema\Permissao\PermissaoClass();
        
        $this->crudUtil->startTransaction();
        
        $perfilCod = $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
        
        $objForm->set('perfilCod',$perfilCod);
        
        $permissao->cadastrar($objForm);
        
        $this->crudUtil->stopTransaction();
    }

    public function alterar($objForm)
    {
        $permissao = new \Sappiens\Sistema\Permissao\PermissaoClass();
        
        $this->crudUtil->startTransaction();
        
        $alterados = $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, [$this->chavePrimaria => $objForm->get('cod')]);
        
        $objForm->set('perfilCod',$objForm->get('cod'));
        
        $permissao->alterar($objForm);
        
        $this->crudUtil->stopTransaction();
        
        return $alterados;
    }

    public function remover($cod)
    {
        $permissao = new \Sappiens\Sistema\Permissao\PermissaoClass();

        if ($this->con->existe('_usuario', 'perfilCod', $cod)) {
            throw new \Exception('Não é possível remover este perfil pois ele possui um ou mais usuários dependentes!');
        }

        $this->crudUtil->startTransaction();

        $permissao->removerPorPerfilCod($cod);

        $removidos = $this->crudUtil->delete($this->tabela, [$this->chavePrimaria => $cod]);

        $this->crudUtil->stopTransaction();

        return $removidos;
    }

    public function setValoresFormManu($cod, $formIntancia, $acao = 'alterar')
    {
        $objForm = $formIntancia->getFormManu($acao, $cod);

        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }
}
