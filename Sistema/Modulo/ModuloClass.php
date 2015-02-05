<?php

namespace Sappiens\Sistema\Modulo;

class ModuloClass extends ModuloSql
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

        $this->tabela = '_modulo';
        $this->chavePrimaria = 'moduloCod';

        $this->colunasCrud = [
            'grupoCod',
            'moduloCodReferente',
            'moduloNome',
            'moduloNomeMenu',
            'moduloDesc',
            'moduloVisivelMenu',
            'moduloPosicao',
            'moduloBase',
            'moduloClass'
        ];

        $this->colunasGrid = [
            'moduloNome' => 'Módulo',
            'grupoNome' => 'Grupo',
            'moduloNomeReferente' => 'Referência',
            'moduloNomeMenu' => 'Nome no Menu',
            'moduloDesc' => 'Descrição',
            'moduloVisivelMenu' => 'Visivel no Menu',
            'moduloPosicao' => 'Posição',
            'moduloBase' => 'É Base?',
            'moduloClass' => 'Ícone'
        ];

        $this->filtroDinamico = [
            'moduloNome' => 'a',
            'grupoNome' => 'b',
            'moduloNomeMenu' => 'a',
            'moduloDesc' => 'a',
            'moduloVisivelMenu' => 'a',
            'moduloPosicao' => 'a',
            'moduloBase' => 'a',
            'moduloClass' => 'a'
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));

        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->naoOrdenePor(['moduloClass']);
        $grid->converterResultado($this, 'mostraIcone', 'moduloClass', ['moduloClass']);
        $grid->converterResultado($this, 'htmlMudaPosicao', 'moduloPosicao', ['moduloCod', 'moduloPosicao']);
        $grid->setAlinhamento(['moduloClass' => 'Centro', 'moduloPosicao' => 'Centro', 'moduloBase' => 'Centro', 'moduloVisivelMenu' => 'Centro']);
        $grid->substituaPor('moduloNomeReferente', ['<i>sem referencia</i>']);
        $grid->substituaPor('moduloBase', ['<em>não informado</em>']);
        $grid->substituaPor('moduloVisivelMenu', ['S' => 'Sim', 'N' => 'Não']);

        return $grid->montaGridPadrao();
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
        $permissao = new \Sappiens\Sistema\Permissao\PermissaoClass();
        
        if($this->con->existe('_modulo', 'moduloCodReferente', $cod)){
            throw new \Exception('Não é possível remover este módulo pois ele possui um ou mais módulos dependentes!');
        }
        
        $this->crudUtil->startTransaction();        

        $permissao->removerPorModuloCod($cod);
        
        $this->crudUtil->delete('_acao_modulo', [$this->chavePrimaria => $cod]);
        
        $removidos = $this->crudUtil->delete($this->tabela, [$this->chavePrimaria => $cod]);
        
        $this->crudUtil->stopTransaction();
        
        return $removidos;
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }

    public function mudaPosicao($moduloCod, $maisMenos)
    {
        $qb = $this->con->link()->createQueryBuilder();

        $qb->select('moduloPosicao')
                ->from('_modulo', '')
                ->where($qb->expr()->eq('moduloCod', ':moduloCod'))
                ->setParameter('moduloCod', $moduloCod, \PDO::PARAM_INT);

        $posicaoAtual = $this->con->execRLinha($qb);

        if ($maisMenos === '+') {
            $novaPosicao = $posicaoAtual + 1;

            if ($novaPosicao > 99) {
                throw new \Exception('O valor máximo já foi alcançado!');
            }
        } else {
            $novaPosicao = $posicaoAtual - 1;

            if ($novaPosicao < 1) {
                throw new \Exception('O valor mínimo já foi alcançado!');
            }
        }

        $update = array('moduloPosicao' => array('Inteiro' => $novaPosicao));

        $this->crudUtil->update($this->tabela, ['moduloPosicao'], $update, [$this->chavePrimaria => $moduloCod] );

        return $novaPosicao;
    }

    public function htmlMudaPosicao($moduloCod, $posicao)
    {
        return '<button type="button" class="btn btn-xs" onclick="mudaPosicao(' . $moduloCod . ', \'-\')"><i class="fa fa-minus-square-o"></i></button>
            <button type="button" class="btn btn-xs"><span id="moduloPosicao' . $moduloCod . '"> ' . $posicao . ' </span></button>
            <button type="button" class="btn btn-xs" onclick="mudaPosicao(' . $moduloCod . ', \'+\')"><i class="fa fa-plus-square-o"></i></button>';
    }

    public function mostraIcone($moduloClass)
    {
        return '<i class="' . $moduloClass . '"></i>';
    }

}
