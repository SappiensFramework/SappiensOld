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

        parent::__construct();
        $this->crudUtil = new \Pixel\Crud\CrudUtil();
        $this->con = \Zion\Banco\Conexao::conectar();

        $this->tabela           = 'pessoa_fisica';        
        $this->precedencia      = 'pessoaFisica';      
        $this->tabela2          = 'organograma';        
        $this->precedencia2     = 'organograma';                
        $this->chavePrimaria    = $this->precedencia . 'Cod';
        $this->colunasGrid = [                                                                                                                    
                    $this->precedencia  . 'Nome'                 => 'Nome', 
                    $this->precedencia  . 'DataNascimento'       => 'Nascimento', 
                    $this->precedencia  . 'Sexo'                 => 'Sexo',                     
                    $this->precedencia  . 'Status'               => 'Status'
        ];                
        $this->filtroDinamico = [
            $this->precedencia . 'Nome'         => "",
            $this->precedencia . 'Status'       => ""
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
        $grid->setFormatarComo($this->precedencia . 'DataNascimento', 'DATA');
        $grid->substituaPor($this->precedencia . 'Sexo', ['M' => 'Masculino', 'F' => 'Feminino']);
        $grid->substituaPor($this->precedencia . 'Status', ['A' => 'Ativo', 'I' => 'Inativo']);

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

        return $this->crudUtil->update($this->tabela, $this->colunas, $objForm, [$this->chavePrimaria => $objForm->get('cod')]);           

    }

    public function alterarDocumento($objForm)
    {

        $upload = new \Pixel\Arquivo\ArquivoUpload();

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
        $retorno = false;

        $campos = $this->getCampos($objForm->get('pessoaDocumentoTipoCod')); 
        $pCod = $objForm->get('pessoaDocumentoTipoCod');

        $obj = $objForm->getObjetos();

        foreach ($obj as $objetos) {

            if ($objetos->getTipoBase() === 'upload') {

                $objetos->setCodigoReferencia($pCod);
                $upload->sisUpload($objetos);   
                $retorno = true;  

            } else {

                if ($objetos->getTipoBase() === 'hidden') continue;

                $formCampoValor = $objetos->getValor();
                $formCampoAtributos = $objetos->getAtributos();

                $persistencia = $this->getValorPersistencia($formCampoAtributos['_pCod'], $objForm->get('cod'));

                if(empty($formCampoValor)) continue;
                if(empty($persistencia['pessoaDocumentoValor'])) $persistencia['pessoaDocumentoValor'] = '';

                if($formCampoValor <> $persistencia['pessoaDocumentoValor']) {

                    if(!empty($persistencia['pessoaDocumentoCod'])) {

                        $objForm->set('pessoaDocumentoStatus', 'I');
                        $this->con->executar(parent::setDocumentoInativo($formCampoAtributos['_pCod'], $objForm->get('cod'), $persistencia['pessoaDocumentoCod']));

                    }

                    $objForm->set('organogramaCod', $_SESSION['organogramaCod']);
                    $objForm->set('pessoaCod', $objForm->get('cod'));
                    $objForm->set('pessoaDocumentoTipoCod', $formCampoAtributos['_pCod']);
                    $objForm->set('pessoaDocumentoValor', $formCampoValor);

                    $retorno .= $this->crudUtil->insert($this->tabela, $this->colunas, $objForm);                    


                }

            }

        }

        $this->con->stopTransaction();

        return $retorno;       

    }    
    
    public function remover($cod)
    {
        
        return $this->crudUtil->delete($this->tabela, [$this->chavePrimaria => $cod]);
        
    }

    public function setValoresFormManu($cod, $formIntancia)
    {

        $objForm = $formIntancia->getFormManu('alterar', $cod);

        $parametrosSql = $this->con->linha(parent::getDadosSql($cod)->execute(), \PDO::FETCH_ASSOC);

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

            $offset = $data['pessoadocumentotiporelacionamentotabelacolunanome'];
            $suggest = $this->con->execLinhaArray(parent::getValorSuggest($data));
            return (!empty($suggest[$offset])) ? $suggest[$offset] : '';

        }

        return (!empty($data['pessoadocumentovalor'])) ? $data['pessoadocumentovalor'] : '';

    }     

    public function getValorPersistencia($cod, $pessoaCod)
    {

        return $this->con->execLinhaArray(parent::getValorPersistencia($cod, $pessoaCod));

    }      

}