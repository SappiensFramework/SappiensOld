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

        $this->con->startTransaction();
        $this->tabela           = 'pessoa_documento';        
        $this->precedencia      = 'pessoaDocumento';                  
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunas = [
										 'organogramaCod',
										 'pessoaCod',
                    $this->precedencia . 'TipoCod',
					$this->precedencia . 'Valor'
        ];
        $retorno = 'true';

        $campos = $this->getCampos($objForm->get('pessoaDocumentoTipoCod')); 

        while($data = $campos->fetch_array()) {

            $persistencia = $this->getValorPersistencia($data['pessoaDocumentoTipoCod'], $objForm->get('cod'));

            if(empty($persistencia['pessoaDocumentoCod'])) {
                $persistencia['pessoaDocumentoCod'] = '';
                $persistencia['pessoaDocumentoValor'] = '';
            }

            if($objForm->get('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']) <> $persistencia['pessoaDocumentoValor']) {

                if(!empty($persistencia['pessoaDocumentoCod'])) {

                    $this->colunasUpdate = [
                                $this->precedencia . 'Status'
                    ];
                    $objForm->set('pessoaDocumentoStatus', 'I');

                    $this->con->executar(parent::setDocumentoInativo($data['pessoaDocumentoTipoCod'], $objForm->get('cod'), $persistencia['pessoaDocumentoCod']));

                }

                if(empty($objForm->get('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']))) continue;

				$objForm->set('organogramaCod', $_SESSION['organogramaCod']);
				$objForm->set('pessoaCod', $objForm->get('cod'));
				$objForm->set('pessoaDocumentoTipoCod', $data['pessoaDocumentoTipoCod']);
                $objForm->set('pessoaDocumentoValor', $objForm->get('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']));

                $retorno = $this->crudUtil->insert($this->tabela, $this->colunas, $objForm);

            }

        }

        $this->con->stopTransaction();

        return $retorno;       

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

    public function getValor($cod, $pessoaCod, $modo = '')
    {

        $data = $this->con->execLinhaArray(parent::getValorSql($cod, $pessoaCod, $modo));

        if($modo == "suggest" and !empty($data)) {

            $offset = $data['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'];
            $suggest = $this->con->execLinhaArray(parent::getValorSuggest($data));
            return (!empty($suggest[$offset])) ? $suggest[$offset] : '';

        }

        return (!empty($data['pessoaDocumentoValor'])) ? $data['pessoaDocumentoValor'] : '';

    }     

    public function getValorPersistencia($cod, $pessoaCod)
    {

        return $this->con->execLinhaArray(parent::getValorPersistencia($cod, $pessoaCod));

    }      

}