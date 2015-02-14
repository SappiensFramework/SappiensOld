<?php

namespace Sappiens\Sistema\Grupo;

class GrupoClass extends GrupoSql
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

        $this->tabela = '_grupo';
        $this->chavePrimaria = 'grupoCod';

        $this->colunasCrud = [
            'grupoNome',
            'grupoPacote',
            'grupoPosicao',
            'grupoClass'
        ];

        $this->colunasGrid = [
            'grupoNome' => "Grupo",
            'grupoPacote' => "Diretório",
            'grupoPosicao' => "Posição",
            'grupoClass' => "Ícone"
        ];

        $this->filtroDinamico = [
            'grupoNome' => "",
            'grupoPacote' => "",
            'grupoPosicao' => "",
            'grupoClass' => ""
        ];
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->crudUtil->getParametrosGrid($objForm));

        $grid->setColunas($this->colunasGrid);

        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->naoOrdenePor(['grupoClass']);
        $grid->converterResultado($this, 'mostraIcone', 'grupoClass', ['grupoClass']);
        $grid->converterResultado($this, 'htmlMudaPosicao', 'grupoPosicao', ['grupoCod', 'grupoPosicao']);
        $grid->setAlinhamento(['grupoClass' => 'Centro', 'grupoPosicao' => 'Centro']);

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $grupoCod = $this->crudUtil->insert($this->tabela, $this->colunasCrud, $objForm);
        
        $this->criaPasta($objForm);
        
        return $grupoCod;
    }

    public function alterar($objForm)
    {
        $afetados = $this->crudUtil->update($this->tabela, $this->colunasCrud, $objForm, [$this->chavePrimaria => $objForm->get('cod')]);
        
        $this->criaPasta($objForm);
        
        return $afetados;
    }

    public function remover($cod)
    {
        return $this->crudUtil->delete($this->tabela, [$this->chavePrimaria => $cod]);
    }

    private function criaPasta($objForm)
    {
        $arq = new \Zion\Arquivo\ManipulaDiretorio();

        $diretorio = SIS_DIR_BASE . $objForm->get('grupoPacote');

        try {
            $arq->criaDiretorio($diretorio, 0777);
        } catch (\Exception $ex) {
            //se não conseguir criar a pasta não tem problema
        }
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }

    public function mudaPosicao($grupoCod, $maisMenos)
    {
        $con = \Zion\Banco\Conexao::conectar();
        $qb = $con->link()->createQueryBuilder();

        $qb->select('grupoPosicao')
                ->from('_grupo', '')
                ->where($qb->expr()->eq('grupoCod', ':grupoCod'))
                ->setParameter('grupoCod', $grupoCod, \PDO::PARAM_INT);

        $posicaoAtual = $con->execRLinha($qb);

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

        $update = array('grupoPosicao' => array('Inteiro' => $novaPosicao));

        $this->crudUtil->update($this->tabela, ['grupoPosicao'], $update, [$this->chavePrimaria => $grupoCod]);

        return $novaPosicao;
    }

    public function htmlMudaPosicao($grupoCod, $posicao)
    {
        return '<button type="button" class="btn btn-xs" onclick="mudaPosicao(' . $grupoCod . ', \'-\')"><i class="fa fa-minus-square-o"></i></button>
            <button type="button" class="btn btn-xs"><span id="grupoPosicao' . $grupoCod . '"> ' . $posicao . ' </span></button>
            <button type="button" class="btn btn-xs" onclick="mudaPosicao(' . $grupoCod . ', \'+\')"><i class="fa fa-plus-square-o"></i></button>';
    }

    public function mostraIcone($grupoClass)
    {
        return '<i class="' . $grupoClass . '"></i>';
    }

}
