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

namespace Sappiens\Sistema\Issue;

class IssueClass extends IssueSql
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

        $this->tabela           = '_issue';        
        $this->precedencia      = 'issue';                   
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunasCrud = [
                    $this->precedencia . 'Num',
                    $this->precedencia . 'Nome',
                    $this->precedencia . 'Desc',
                    $this->precedencia . 'Rep',
                    $this->precedencia . 'Data',
                    $this->precedencia . 'Status'
        ];
        $this->colunasGrid = [                                                                                                              
                    $this->precedencia  . 'Num'                  => 'Id',                          
                    $this->precedencia  . 'Nome'                 => 'Issue',                          
                    $this->precedencia  . 'Rep'                  => 'Reporter',    
                    $this->precedencia  . 'Data'                 => 'Data',
                    $this->precedencia  . 'Status'               => 'Status'
        ];    
        $this->filtroDinamico = [
            $this->precedencia . 'Nome'   => "",
            $this->precedencia . 'Rep'    => "",
            $this->precedencia . 'Status' => ""
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
        $grid->substituaPor($this->precedencia . 'Status', ['N' => 'Novo', 'C' => 'Corrigindo', 'T' => 'Testando', 'H' => 'Homologado']);

        return $grid->montaGridPadrao();

    }

    public function cadastrar($objForm)
    {

        $cod = $objForm->get('cod');
        $d = $this->con->execLinhaArray(parent::getIssueNumSql($cod));
        $objForm->set('issueNum', ($d['issuenum']+=1));
        $objForm->set('issueStatus', 'N');

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

    public function setValoresFormManu($cod, $formInstancia)
    {

        $objForm = $formInstancia->getFormManu('alterar', $cod);
        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));
        $objetos = $objForm->getObjetos();

        //Intervenção para o campo escolha
        //$objetos['moduloExeEscolhaVarios[]']->setValor(\explode(',', $parametrosSql['moduloexeescolhavarios']));

        //Intervenção para o campo chosen
        //$objetos['moduloExeChosenMultiplo[]']->setValor(\explode(',', $parametrosSql['moduloexechosenmultiplo']));

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;

    }

    public function getDadosGrupo()
    {
        
        return $this->con->execLinhaArray(parent::getDadosGrupoSql());

    }     

    public function getDadosModulo()
    {
        
        return $this->con->execLinhaArray(parent::getDadosModuloSql());

    }     

}