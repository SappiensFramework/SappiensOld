<?php

namespace Sappiens\GestaoAdministrativa\PessoaFisica;

class PessoaFisicaClass extends PessoaFisicaSql
{
    
    private $chavePrimaria;
    private $tabela;
    private $precedencia;
    private $colunas;
    private $colunasGrid;
    
    public function __construct()
    {

        $this->crudUtil = new \Pixel\Crud\CrudUtil();
        $this->con = \Zion\Banco\Conexao::conectar();

        $this->tabela           = 'pessoa_fisica';        
        $this->precedencia      = 'pessoaFisica';      
        $this->tabela2          = 'organograma';        
        $this->precedencia2     = 'organograma';                
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunasGrid = [                                                                                                                    
                    $this->precedencia  . 'Nome'                 => 'Nome',         
                    $this->precedencia  . 'Sexo'                 => 'Sexo',                     
                    $this->precedencia  . 'Status'               => 'Status'
        ];                
    }   

    public function getParametrosGrid($objForm)
    {
        $fil = new \Pixel\Filtro\Filtrar();
        //$crud = new \Pixel\Crud\CrudUtil();

        $padrao = ["pa", "qo", "to"];

        $meusParametros = $this->crudUtil->getParametrosForm($objForm);
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
        //$crud = new \Pixel\Crud\CrudUtil();

        $this->tabelaA          = 'pessoa';        
        $this->precedencia      = 'pessoa';  
        $this->precedencia2     = 'organograma';
        $this->colunasA = [
                    $this->precedencia . 'Cod',
                    $this->precedencia2. 'Cod',
                    $this->precedencia . 'Tipo',
                    $this->precedencia . 'Status'
        ];        

        $objForm->set('organogramaCod', $_SESSION['organogramaCod']);
        $objForm->set('pessoaTipo', 'F');
        $objForm->set('pessoaStatus', 'A');

        $pessoaCod = $this->crudUtil->insert($this->tabelaA, $this->colunasA, $objForm);

        $this->tabelaB          = 'pessoa_fisica';        
        $this->precedencia      = 'pessoaFisica';  
        $this->precedencia2     = 'organograma';
        $this->colunasB = [
                    $this->precedencia . 'Cod',
                    $this->precedencia2. 'Cod',
                    $this->tabelaA     . 'Cod',
                    $this->precedencia . 'EstadoCivilCod',
                    $this->precedencia . 'RacaCod',
                    $this->precedencia . 'Nome',
                    $this->precedencia . 'DataNascimento',
                    $this->precedencia . 'Sexo',
                    $this->precedencia . 'Status'
        ]; 

        $objForm->set('pessoaCod', $pessoaCod);
        $objForm->set('pessoaFisicaStatus', 'A');        

        return $this->crudUtil->insert($this->tabelaB, $this->colunasB, $objForm);

    }
    
    public function alterar($objForm)
    {

        $this->tabela           = 'pessoa_fisica';        
        $this->precedencia      = 'pessoaFisica';                  
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunas = [
                    $this->precedencia . 'EstadoCivilCod',
                    $this->precedencia . 'RacaCod',
                    $this->precedencia . 'Nome',
                    $this->precedencia . 'DataNascimento',
                    $this->precedencia . 'Sexo',
                    $this->precedencia . 'Status'
        ];         

        //return true;
        //return $this->crudUtil->update($this->tabela, $this->colunas, $objForm, $this->chavePrimaria);           

    }

    public function alterarDocumento($objForm)
    {


        $this->tabela           = 'pessoa_documento';        
        $this->precedencia      = 'pessoaDocumento';                  
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunas = [
                    $this->precedencia . 'TipoCod'
        ];

        $campos = $this->getCampos($objForm->get('pessoaDocumentoTipoCod')); 

        //$var = $objForm->get('n');
        //exit($var);

        //print_r($objForm);


        while($data = $campos->fetch_array()) {

            //$var = $objForm->get('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);
            //echo $var;
            //echo $data['pessoaDocumentoTipoCod'];
            //echo $var;
            //echo $objForm->get('pessoaDocumentoTipoCod_25');

            if($objForm->get('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'])) {

                $objForm->set('pessoaDocumentoValor', $objForm->get('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']));

                $ins = $this->crudUtil->insert($this->tabela, $this->colunas, $objForm);

            }

        }

        return $ins;
        //return $this->crudUtil->update($this->tabela, $this->colunas, $objForm, $this->chavePrimaria);           

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

    public function setValoresFormManuDocumento($cod, $formIntancia)
    {

        $objForm = $formIntancia->getFormManuDocumento('alterar', $cod);

        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));

        $objetos = $objForm->getObjetos();

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    } 

    public function setValoresFormManuContato($cod, $formIntancia)
    {

        $objForm = $formIntancia->getFormManuContato('alterar', $cod);

        $parametrosSql = $this->con->execLinhaArray(parent::getDadosSql($cod));

        $objetos = $objForm->getObjetos();

        $this->crudUtil->setParametrosForm($objForm, $parametrosSql, $cod);

        return $objForm;
    }    

    public function getCampos($cod)
    {

        return $this->con->executar(parent::getCamposSql($cod));

    }

    public function getRelacionamento($cod, $modo)
    {

        return $this->con->execLinhaArray(parent::getRelacionamento($cod, $modo));

    }     

}