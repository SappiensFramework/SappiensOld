<?php
/*

    Sappiens Framework
    Copyright (C) 2014, BRA Consultoria

    Website do autor: www.braconsultoria.com.br/sappiens
    Email do autor: sappiens@braconsultoria.com.br

    Website do projeto, equipe e documentação: www.sappiens.com.br
   
    Este programa é software livre; você pode redistribuí-lo e/ou
    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
    publicada pela Free Software Foundation, versão 2.

    Este programa é distribuído na expectativa de ser útil, mas SEM
    QUALQUER GARANTIA; sem mesmo a garantia implícita de
    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
    detalhes.
 
    Você deve ter recebido uma cópia da Licença Pública Geral GNU
    junto com este programa; se não, escreva para a Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
    02111-1307, USA.

    Cópias da licença disponíveis em /Sappiens/_doc/licenca

*/

namespace Sappiens\Configuracoes\OrganogramaClassificacao;

class OrganogramaClassificacaoClass extends OrganogramaClassificacaoSql
{
    
    private $chavePrimaria;
    private $chaveEstrangeira;
    private $tabela;
    private $precedencia;
    private $colunasCrud;
    private $colunasGrid;
    
    public function __construct()
    {
        $this->tabela           = 'organograma_classificacao';        
        $this->precedencia      = 'organogramaClassificacao';      
        $this->chavePrimaria    = $this->precedencia . 'Cod';

        $this->tabela2          = 'organograma_classificacao_tipo';   
        $this->precedencia2     = 'organogramaClassificacaoTipo';  
        $this->chaveEstrangeira = $this->precedencia2 . 'Cod';

        $this->colunasCrud = [
                    $this->precedencia . 'ReferenciaCod',
                    $this->precedencia . 'Ancestral',
                    $this->chaveEstrangeira,
                    $this->precedencia . 'Nome',
                    $this->precedencia . 'Ordem',
                    $this->precedencia . 'Reordenavel',
                    $this->precedencia . 'Status'
        ];
        $this->colunasGrid = [                                                                                   
                    //$this->precedencia . 'ReferenciaCombinado'  => 'Classificação combinada',                                  
                    $this->precedencia . 'Ordem'                => 'Ordem',         
                    $this->precedencia . 'Nome'                 => 'Classificação',                      
                    $this->precedencia . 'Status'               => 'Status'
        ];                
    }   

    public function getParametrosGrid($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();
        $crud = new \Pixel\Crud\CrudUtil();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $crud->getParametrosForm($objForm);
        $hiddenParametros = $fil->getHiddenParametros($meusParametros);

        return array_merge($padrao, $meusParametros, $hiddenParametros);
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        //Setando Parametros
        \Zion\Paginacao\Parametros::setParametros("GET", $this->getParametrosGrid($objForm));

        //Grid de Visualização - Configurações
        $grid->setColunas($this->colunasGrid);

        //Configurações Fixas da Grid
        $grid->setSql(parent::filtrarSql($objForm,$this->colunasGrid));
        $grid->setChave($this->chavePrimaria);
        $grid->setSelecaoMultipla(true);
        //$grid->setAlinhamento(array('organogramaClassificacaoOrdem' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        $dadosReferencia = $this->getDadosByReferencia($objForm->get('organogramaClassificacaoReferenciaCod'));

        if(!$objForm->get('organogramaClassificacaoTipoCod')) {
            $objForm->set('organogramaClassificacaoTipoCod', $dadosReferencia['organogramaClassificacaoTipoCod']);
        }        

        $organogramaClassificacaoNovo = $crud->insert($this->tabela, $this->colunasCrud, $objForm);

        if($dadosReferencia['organogramaClassificacaoAncestral']) {
            $objForm->set('organogramaClassificacaoAncestral', "|" . $organogramaClassificacaoNovo . $dadosReferencia['organogramaClassificacaoAncestral']);   
        }

        $objForm->set('cod', $organogramaClassificacaoNovo);  

        return $crud->update($this->tabela, ['organogramaClassificacaoAncestral'], $objForm, $this->chavePrimaria);

    }
    
    public function alterar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();

        if(!$objForm->get('organogramaClassificacaoTipoCod')) {
            $k = array_search('organogramaClassificacaoTipoCod', $this->colunasCrud);
            unset($this->colunasCrud[$k]);
        }        

        $dadosReferencia = $this->getDadosByReferencia($objForm->get('organogramaClassificacaoReferenciaCod')); 
        $organogramaClassificacaoAncestral = $dadosReferencia['organogramaClassificacaoAncestral'];

        if($organogramaClassificacaoAncestral) $objForm->set('organogramaClassificacaoAncestral', "|" . $objForm->get('cod') . $organogramaClassificacaoAncestral);    

        return $crud->update($this->tabela, $this->colunasCrud, $objForm, $this->chavePrimaria);
    }
    
    public function remover($cod)
    {
        $crud = new \Pixel\Crud\CrudUtil();
        return $crud->delete($this->tabela, $cod, $this->chavePrimaria);
    }

    public function setValoresFormManu($cod, $formIntancia)
    {
        $util = new \Pixel\Crud\CrudUtil();

        $con = \Zion\Banco\Conexao::conectar();

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $con->execLinhaArray(parent::getDadosSql($cod));

        $util->setParametrosForm($objForm, $parametrosSql, $cod);
        
        return $objForm;
    }
/*
    public function getOrdem($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $param = $con->execLinhaArray(parent::getOrdem($cod, 'referencia'));

        if(empty($param['ordemAtual'])) {

            $param = $con->execLinhaArray(parent::getOrdem($cod));
            return $param['ordemAtual'] . '.1';

        } else {

            $tam = strlen(strrchr($param['ordemAtual'], '.'));
            $parcial = substr($param['ordemAtual'], 0, -$tam);
            $final = substr(strrchr($param['ordemAtual'], '.'), 1)+1;
            return $parcial . '.' . $final;

        }

    }    
*/

    public function getOrdem($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $param = $con->execLinhaArray(parent::getOrdem($cod, 'referencia'));

        if(strlen($param['ordemAtual']) <= 0) {

            $param = $con->execLinhaArray(parent::getOrdem($cod));
            if(strlen($param['ordemAtual']) <= 0) {
                return 1;
            } else {
                return $param['ordemAtual'] . '.1';
            }

        } else {

            $tam = strlen(strrchr($param['ordemAtual'], '.'));
            $parcial = substr($param['ordemAtual'], 0, -$tam);
            $final = substr(strrchr($param['ordemAtual'], '.'), 1)+1;
            return $parcial . '.' . $final;

        }

    } 

    public function getOrganogramaClassificacaoReferenciaCod($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        return $con->paraArray(parent::getOrganogramaClassificacaoReferenciaCod($cod),'valor','chave');

    }      

    private function getDadosByReferencia($cod)
    {

        $con = \Zion\Banco\Conexao::conectar();
        return $con->execLinhaArray(parent::getDadosSql($cod));

    }     

    private function getOrganogramaClassificacaoAncestralByOrganogramaClassificacaoReferenciaCod($cod)
    {

        $con = \Zion\Banco\Conexao::conectar();
        $dados = $con->execLinhaArray(parent::getDadosSql($cod));
        return $dados['organogramaClassificacaoAncestral'];

    }    

}