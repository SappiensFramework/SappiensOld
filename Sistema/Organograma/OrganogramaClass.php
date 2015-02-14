<?php
/**
*
*    Sappiens Framework
*    Copyright (C) 2014, BRA Consultoria
*
*    Website do autor: www.braconsultoria.com.br/sappiens
*    Email do autor: sappiens@braconsultoria.com.br
*
*    Website do projeto, equipe e documentação: www.sappiens.com.br
*   
*    Este programa é software livre; você pode redistribuí-lo e/ou
*    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
*    publicada pela Free Software Foundation, versão 2.
*
*    Este programa é distribuído na expectativa de ser útil, mas SEM
*    QUALQUER GARANTIA; sem mesmo a garantia implícita de
*    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
*    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
*    detalhes.
* 
*    Você deve ter recebido uma cópia da Licença Pública Geral GNU
*    junto com este programa; se não, escreva para a Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
*    02111-1307, USA.
*
*    Cópias da licença disponíveis em /Sappiens/_doc/licenca
*
*/

namespace Sappiens\Configuracoes\Organograma;

class OrganogramaClass extends OrganogramaSql
{
    
    private $chavePrimaria;
    private $tabela;
    private $precedencia;
    private $colunas;
    private $colunasGrid;
    
    public function __construct()
    {

        parent::__construct();
        $this->crudUtil = new \Pixel\Crud\CrudUtil();
        $this->con = \Zion\Banco\Conexao::conectar();

        $this->tabela           = 'organograma';        
        $this->precedencia      = 'organograma';      
        $this->tabela2          = 'organograma_classificacao';        
        $this->precedencia2     = 'organogramaClassificacao';                
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunas = [
                    $this->precedencia . 'ReferenciaCod',
                    $this->precedencia . 'Ancestral',
                    $this->precedencia . 'ClassificacaoCod',
                    $this->precedencia . 'Nome',
                    $this->precedencia . 'Ordem',
                    $this->precedencia . 'Ordenavel',
                    $this->precedencia . 'Status'
        ];
        $this->colunasGrid = [                                                                                                              
                    $this->precedencia  . 'Ordem'                => 'Ordem',         
                    $this->precedencia2 . 'Nome'                 => 'Classificação',                     
                    $this->precedencia  . 'Nome'                 => 'Organograma',   
                    $this->precedencia  . 'Status'               => 'Status'
        ];    
        $this->filtroDinamico = [
            $this->precedencia . 'Nome' => ""
        ];                    
    }   

    public function getParametrosGrid($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $this->crudUtil->getParametrosForm($objForm);
        $hiddenParametros = $fil->getHiddenParametros($meusParametros);

        return array_merge($padrao, $meusParametros, $hiddenParametros);
    }

    public function filtrar($objForm)
    {
        $grid = new \Pixel\Grid\GridPadrao();

        \Zion\Paginacao\Parametros::setParametros("GET", $this->getParametrosGrid($objForm));

        $grid->setColunas($this->colunasGrid);

        //$grid->setSql(parent::filtrarSql($objForm,$this->colunasGrid));
        $grid->setSql(parent::filtrarSql($objForm, $this->filtroDinamico));
        $grid->setChave($this->chavePrimaria);
        $grid->setSelecaoMultipla(true);
        //$grid->setAlinhamento(array('organogramaOrdem' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {

        if($objForm->get('organogramaOrdenavel') == "I") $objForm->set('organogramaOrdem', '');

        $organogramaAncestral = $this->getOrganogramaAncestralByOrganogramaReferenciaCod($objForm->get('organogramaReferenciaCod'));
        $organogramaNovo = $this->crudUtil->insert($this->tabela, $this->colunas, $objForm);
        if($organogramaAncestral) $objForm->set('organogramaAncestral', "|" . $organogramaNovo . $organogramaAncestral);   
        
        $objForm->set('cod', $organogramaNovo);  
        return $this->crudUtil->update($this->tabela, ['organogramaAncestral'], $objForm, $this->chavePrimaria);
    }
    
    public function alterar($objForm)
    {


        if(!$objForm->get('organogramaOrdem')){
            $k = array_search('organogramaOrdem', $this->colunas);
            unset($this->colunas[$k]);            
        }
        if($objForm->get('organogramaOrdenavel') == "I") $objForm->set('organogramaOrdem', '');
        if(!$this->getClassificacaoReordenavel($objForm->get('cod'))) {
            $k = array_search('organogramaClassificacaoCod', $this->colunas);
            unset($this->colunas[$k]);
        }

        $organogramaAncestral = $this->getOrganogramaAncestralByOrganogramaReferenciaCod($objForm->get('organogramaReferenciaCod'));       
        if($organogramaAncestral) $objForm->set('organogramaAncestral', "|" . $objForm->get('cod') . $organogramaAncestral);    
                
        return $this->crudUtil->update($this->tabela, $this->colunas, $objForm, $this->chavePrimaria);
    }
    
    public function remover($cod)
    {

        return $this->crudUtil->delete($this->tabela, $cod, $this->chavePrimaria);

    }

    public function setValoresFormManu($cod, $formIntancia)
    {

        $objForm = $formIntancia->getFormManu('alterar', $cod);
        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));
        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);
        
        return $objForm;
    }

    public function getOrdem($cod)
    {
        
        $param = $this->con->execLinhaArray(parent::getOrdem($cod, 'referencia'));

        if(strlen($param['ordematual']) <= 0) {

            $param = $this->con->execLinhaArray(parent::getOrdem($cod));
            if(strlen($param['ordematual']) <= 0) {
                return 1;
            } else {
                return $param['ordematual'] . '.1';
            }

        } else {

            if(!strstr($param['ordematual'], '.')) return $param['ordematual']+=1;
            $tam = strlen(strrchr($param['ordematual'], '.'));
            $parcial = substr($param['ordematual'], 0, -$tam);
            $final = substr(strrchr($param['ordematual'], '.'), 1)+1;
            return $parcial . '.' . $final;

        }

    }    

    public function getOrganogramaClassificacaoCod($cod)
    {
        
        return $this->con->paraArray(parent::getOrganogramaClassificacaoCod($cod),'valor','chave');

    }    

    //supostamente, não utilizado
    public function getOrganogramaClassificacaoTipoCod($cod)
    {
        
        $dados1 = $this->con->execLinhaArray(parent::getOrganogramaClassificacaoCodByOrganogramaCod($cod));
        $dados2 = $this->con->execLinhaArray(parent::getOrganogramaClassificacaoTipoCodByOrganogramaClassificacaoCod($dados1['organogramaclassificacaocod']));
        return $this->con->paraArray(parent::getOrganogramaClassificacaoCodByOrganogramaClassificacaoTipoCod($dados2['organogramaclassificacaotipocod']),'valor','chave');

    }   

    public function getOrganogramaClassificacaoByReferencia($cod)
    {
        
        $d1 = $this->con->execLinhaArray(parent::getOrganogramaClassificacaoCodByOrganogramaCod($cod));
        return $this->con->paraArray(parent::getOrganogramaClassificacaoByReferencia($d1['organogramaclassificacaocod']),'valor','chave');

    }         

    public function getClassificacaoReordenavel($cod)
    {
        
        $param = $this->con->execLinhaArray(parent::getClassificacaoReordenavel($cod));
        return ($param['organogramaclassificacaoreordenavel'] == "S") ? true : false;

    }      

    public function getOrganograma($cod)
    {

        $i     = 0;
        $count = 1;
        $value = '';
        $value = $this->getOrganogramaCodByOrganogramaReferenciaCod($cod);

        $buffer  = '';
        
        if(is_array($value)) {

            while($i <= $count) {

                $buffer .= $value['organogramaNome'];
                $value = $this->getOrganogramaCodByOrganogramaReferenciaCod($value['organogramaCod']);

            }
        }

    }    

    public function getOrganogramaCodByOrganogramaReferenciaCod($cod)
    {

        return $this->con->execLinhaArray(parent::getOrganogramaReferenciaCod($cod));

    }

    private function getOrganogramaAncestralByOrganogramaReferenciaCod($cod)
    {

        $dados = $this->con->execLinhaArray(parent::getDadosSql($cod));
        return $dados['organogramaAncestral'];

    }

}