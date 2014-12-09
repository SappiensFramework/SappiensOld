<?php

namespace Sappiens\Accounts\Login;

class LoginClass extends LoginSql
{
    
    private $chavePrimaria;
    private $tabela;
    private $precedencia;
    private $colunas;
    private $colunasGrid;
    
    public function __construct()
    {
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
                    //$this->precedencia  . 'ReferenciaCombinado'  => 'Posição combinada',                                  
                    $this->precedencia  . 'Ordem'                => 'Ordem',         
                    $this->precedencia2 . 'Nome'                 => 'Classificação',                     
                    $this->precedencia  . 'Nome'                 => 'Organograma',   
                    $this->precedencia  . 'Status'               => 'Status'
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
        //$grid->setAlinhamento(array('organogramaOrdem' => 'DIREITA'));
        $grid->setTipoOrdenacao(filter_input(INPUT_GET, 'to'));
        $grid->setQuemOrdena(filter_input(INPUT_GET, 'qo'));
        $grid->setPaginaAtual(filter_input(INPUT_GET, 'pa'));

        return $grid->montaGridPadrao();
    }

    public function cadastrar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();

        if($objForm->get('organogramaOrdenavel') == "I") $objForm->set('organogramaOrdem', '');

        $organogramaAncestral = $this->getOrganogramaAncestralByOrganogramaReferenciaCod($objForm->get('organogramaReferenciaCod'));
        $organogramaNovo = $crud->insert($this->tabela, $this->colunas, $objForm);
        if($organogramaAncestral) $objForm->set('organogramaAncestral', "|" . $organogramaNovo . $organogramaAncestral);   
        
        $objForm->set('cod', $organogramaNovo);  
        return $crud->update($this->tabela, ['organogramaAncestral'], $objForm, $this->chavePrimaria);
    }
    
    public function alterar($objForm)
    {
        $crud = new \Pixel\Crud\CrudUtil();

        if($objForm->get('organogramaOrdenavel') == "I") $objForm->set('organogramaOrdem', '');
        if(!$this->getClassificacaoReordenavel($objForm->get('cod'))) {
            $k = array_search('organogramaClassificacaoCod', $this->colunas);
            unset($this->colunas[$k]);
        }

        $organogramaAncestral = $this->getOrganogramaAncestralByOrganogramaReferenciaCod($objForm->get('organogramaReferenciaCod'));       
        if($organogramaAncestral) $objForm->set('organogramaAncestral', "|" . $objForm->get('cod') . $organogramaAncestral);    
                
        return $crud->update($this->tabela, $this->colunas, $objForm, $this->chavePrimaria);
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

    public function getAuth($l,$p)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $sql = new \Sappiens\Accounts\Login\LoginSql();

        $getAuth = $con->execLinhaArray($sql->getAuth($l,$p));

        if(!empty($getAuth['usuarioCod']) and !empty($getAuth['organogramaCod'])) {

            unset($_SESSION['usuarioCod'], $_SESSION['organogramaCod']);

            $_SESSION['usuarioCod']     = $getAuth['usuarioCod'];
            $_SESSION['organogramaCod'] = $getAuth['organogramaCod'];

            return true;

        }

        return false;

    }    

    public function getOrganogramaClassificacaoCod($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        return $con->paraArray(parent::getOrganogramaClassificacaoCod($cod),'valor','chave');

    }    

    //supostamente, não utilizado
    public function getOrganogramaClassificacaoTipoCod($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $dados1 = $con->execLinhaArray(parent::getOrganogramaClassificacaoCodByOrganogramaCod($cod));
        $dados2 = $con->execLinhaArray(parent::getOrganogramaClassificacaoTipoCodByOrganogramaClassificacaoCod($dados1['organogramaClassificacaoCod']));
        return $con->paraArray(parent::getOrganogramaClassificacaoCodByOrganogramaClassificacaoTipoCod($dados2['organogramaClassificacaoTipoCod']),'valor','chave');

    }   

    public function getOrganogramaClassificacaoByReferencia($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $d1 = $con->execLinhaArray(parent::getOrganogramaClassificacaoCodByOrganogramaCod($cod));
        return $con->paraArray(parent::getOrganogramaClassificacaoByReferencia($d1['organogramaClassificacaoCod']),'valor','chave');

    }         

    public function getClassificacaoReordenavel($cod)
    {
        
        $con = \Zion\Banco\Conexao::conectar();
        $param = $con->execLinhaArray(parent::getClassificacaoReordenavel($cod));
        return ($param['organogramaClassificacaoReordenavel'] == "S") ? true : false;

    }      
/*
    public function getOrganograma($cod)
    {

        $i     = 0;
        $count = 1;
        $value = '';
        $value = $this->getOrganogramaCodByOrganogramaReferenciaCod($cod);

        $buffer  = '';
        
        if(is_array($value)) {

            while($i <= $count) {
                $i++;
                $value = $this->getOrganogramaCodByOrganogramaReferenciaCod($value['organogramaCod']);
                if(is_array($value))

            }
        }

    }
*/
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

        $con = \Zion\Banco\Conexao::conectar();
        return $con->execLinhaArray(parent::getOrganogramaReferenciaCod($cod));

    }

    private function getOrganogramaAncestralByOrganogramaReferenciaCod($cod)
    {

        $con = \Zion\Banco\Conexao::conectar();
        $dados = $con->execLinhaArray(parent::getDadosSql($cod));
        return $dados['organogramaAncestral'];

    }

}