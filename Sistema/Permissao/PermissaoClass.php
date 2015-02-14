<?php

namespace Sappiens\Sistema\Permissao;

class PermissaoClass extends PermissaoSql
{

    private $chavePrimaria;
    private $crudUtil;
    private $tabela;
    private $colunasCrud;

    public function __construct()
    {
        parent::__construct();

        $this->crudUtil = new \Pixel\Crud\CrudUtil();

        $this->tabela = '_permissao';
        $this->chavePrimaria = 'permissaoCod';

        $this->colunasCrud = [
            'acaoModuloCod',
            'perfilCod'
        ];
    }

    public function cadastrar($objForm)
    {
        $acaoModulo = \filter_input(\INPUT_POST, 'acaoModulo', \FILTER_DEFAULT, \FILTER_REQUIRE_ARRAY);

        foreach ($acaoModulo as $acaoModuloCod) {
            $objForm->set('acaoModuloCod', $acaoModuloCod, 'Inteiro');
            $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
        }
    }

    public function alterar($objForm)
    {
        $this->removerPorPerfilCod($objForm->get('perfilCod'));
        $this->cadastrar($objForm);
    }

    public function removerPorPerfilCod($cod)
    {
        return $this->crudUtil->delete($this->tabela, ['perfilCod' => $cod]);
    }

    public function removerPorAcaoModuloCod($acaoModuloCod)
    {
        return $this->crudUtil->delete($this->tabela, ['acaoModuloCod' => $acaoModuloCod]);
    }

    public function removerPorModuloCod($moduloCod)
    {
        $qb = $this->con->link()->createQueryBuilder();
        $qb->select('acaoModuloCod')
                ->from('_acao_modulo', '')
                ->where($qb->expr()->eq('moduloCod', '?'))
                ->setParameter(0, $moduloCod);

        $resultados = $this->con->paraArray($qb,'acaoModuloCod');

        foreach ($resultados as $acaoModuloCod) {            
            $this->removerPorAcaoModuloCod($acaoModuloCod);
        }
    }

    public function montaPermissao($acao, $perfilCod)
    {
        $html = new \Zion\Layout\Html();
        $modulo = new \Sappiens\Sistema\Modulo\ModuloClass();
        $acaoModulo = new \Sappiens\Sistema\AcaoModulo\AcaoModuloClass();
        $form = new \Pixel\Form\Form();

        $grupos = $this->con->paraArray((new \Sappiens\Sistema\Grupo\GrupoClass())->gruposSql());
        
        $buffer = '';
        //$buffer = $html->abreTagAberta('div', ['class' => 'displaytable']);
        foreach ($grupos as $dadosGrupo) {

//            $buffer .= $html->abreTagAberta('div', ['class' => 'panel permissoes-usuario']);
//            $buffer .= $html->abreTagAberta('div', ['class' => 'panel-heading']);
//            $buffer .= $html->abreTagAberta('span', ['class' => 'panel-title', 'onclick' => 'toggleBody(this);']);
//            $buffer .= $html->abreTagFechada('i', ['class' => 'fa fa-plus-square-o']);
//            $buffer .= $dadosGrupo['gruponome'];
//            $buffer .= $html->fechaTag('span');
//
//            $buffer .= $html->abreTagAberta('div', ['class' => 'acoes-marcar']);
//            $buffer .= $html->abreTagAberta('button', ['class' => 'btn btn-success btn-sm marca', 'type' => 'button', 'onclick' => 'contar(this);']);
//            $buffer .= $html->abreTagFechada('i', ['class' => 'fa fa-check']);
//            $buffer .= 'Marcar Todos';
//            $buffer .= $html->abreTagFechada('span', ['class' => 'labels label-s']);
//            $buffer .= $html->fechaTag('button');
//            $buffer .= $html->abreTagAberta('button', ['class' => 'btn btn-danger btn-sm desmarca', 'type' => 'button', 'onclick' => 'contar(this);']);
//            $buffer .= $html->abreTagAberta('strong');
//            $buffer .= 'x';
//            $buffer .= $html->fechaTag('strong');
//            $buffer .= 'Desmarcar Todos';
//            $buffer .= $html->abreTagFechada('span', ['class' => 'labels label-no']);
//            $buffer .= $html->fechaTag('button');
//            $buffer .= $html->fechaTag('div');
//            $buffer .= $html->fechaTag('div');
//
//            $buffer .= $html->abreTagAberta('div', ['class' => 'panel-body']);
//            $buffer .= $html->abreTagAberta('form', ['class' => 'form-inline']);
//            $buffer .= $html->abreTagAberta('ul', ['class' => 'list-no-style']);

            $modulos = $this->con->paraArray($modulo->modulosDoGrupoSql($dadosGrupo['grupocod']));

            foreach ($modulos as $dadosModulo) {

                $escolha = [];

                $moduloCod = $dadosModulo['modulocod'];
                $acoes = $this->con->paraArray($acaoModulo->acoesDoModuloSql($moduloCod), 'acaoModuloPermissao', 'acaoModuloCod');

                if(empty($acoes)){
                    continue;
                }
                
                $permissaoUsuario = [];
                if ($acao == 'alterar') {
                    $permissaoUsuario = $this->con->paraArray(parent::permissoesPerfil($moduloCod, $perfilCod), 'acaoModuloCod', 'acaoModuloCod');
                }

                $disabled = $acao == 'visualizar' ? true : false;               
                
                $escolha[] = $form->escolha('acaoModulo[]', $dadosModulo['modulonome'])
                        ->setExpandido(true)
                        ->setMultiplo(true)
                        ->setLayoutPixel(false)
                        ->setDisabled($disabled)
                        ->setValorPadrao($permissaoUsuario)
                        ->setOrderBy(['acaoModuloPosicao' => 'ASC'])
                        ->setOrdena(false)
                        ->setArray($acoes);

//                $buffer .= $html->abreTagAberta('li', ['class' => 'iten-com-checkbox']);
//                $buffer .= $html->abreTagAberta('div', ['class' => 'col-md-2', 'onclick' => 'marcarLinha(this);']);
                $buffer .= $dadosModulo['modulonome'];
//                $buffer .= $html->fechaTag('div');
//
//                $buffer .= $html->abreTagAberta('div', ['class' => 'col-md-10']);
                $buffer .= $form->processarForm($escolha)->getFormHtml('acaoModulo[]')."<br>";
//                $buffer .= $html->fechaTag('div');
//                $buffer .= $html->fechaTag('li');
            }

//            $buffer .= $html->fechaTag('ul');
//            $buffer .= $html->fechaTag('div');
//            $buffer .= $html->fechaTag('div');
        }

//        $buffer .= $html->fechaTag('form');
//        $buffer .= $html->fechaTag('div');

        return $buffer;
    }

}
