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

class PessoaFisicaForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\Form();

        $form->config('formFiltro', 'GET');

        $campos[] = $form->suggest('uf', 'Unidade Federativa')
                ->setTabela('uf')                
                ->setCampoBusca('ufNome')
                ->setCampoDesc('ufNome')
                ->setEmColunaDeTamanho(10);

        //$campos[] = $form->botaoSubmit('enviar', 'Enviar')
        //        ->setClassCss('btn btn-primary');

        return $form->processarForm($campos);
    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $cod = null, $extra = null)
    {

        $form = new \Pixel\Form\Form();
        $acesso = new \Zion\Acesso\Acesso();     

        $form->setAcao($acao);

        $form->config('formManuInicial' . $cod, 'POST')
                ->setHeader('Inicial');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

       $campos[] = $form->hidden('n')
                ->setValor('inicial');                

        $campos[] = $form->texto('pessoaFisicaNome', 'Nome completo', true)
                ->setEmColunaDeTamanho('6')
                ->setValor($form->retornaValor('pessoaFisicaNome'));   

        $campos[] = $form->data('pessoaFisicaDataNascimento', 'Data de nascimento', false)
                ->setEmColunaDeTamanho('6')
                ->setValor($form->retornaValor('pessoaFisicaDataNascimento'));                              

        $campos[] = $form->chosen('pessoaFisicaEstadoCivilCod', 'Estado civil', true)
                ->setValor($form->retornaValor('pessoaFisicaEstadoCivilCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('6')
                ->setTabela('pessoa_fisica_estado_civil')
                ->setCampoCod('pessoaFisicaEstadoCivilCod')
                ->setOrdena(false)
                ->setCampoDesc('pessoaFisicaEstadoCivilNome');  

        $campos[] = $form->chosen('pessoaFisicaRacaCod', 'Raça/cor', true)
                ->setValor($form->retornaValor('pessoaFisicaRacaCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('6')
                ->setTabela('pessoa_fisica_raca')
                ->setCampoCod('pessoaFisicaRacaCod')
                ->setOrdena(false)
                ->setCampoDesc('pessoaFisicaRacaNome');     

        $campos[] = $form->escolha('pessoaFisicaSexo', 'Sexo', true)
                ->setValor($form->retornaValor('pessoaFisicaSexo'))
                ->setEmColunaDeTamanho('6')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(['M' => 'Masculino', 'F' => 'Feminino']);            

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao('formManu' . $cod);          
        
        return $form->processarForm($campos);
    }

    public function getFormManuDocumento($acao, $cod = null)
    {
        $form = new \Pixel\Form\Form();
        $html = new \Zion\Layout\Html();

        $form->setAcao('sisAlterarPadrao($(form).attr("name"),true)');

        $nomeForm = 'formManuDocumento' . $cod;
        
        $form->config($nomeForm, 'POST')
                ->setHeader('Documentos');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->hidden('n')
                ->setValor('documento');                 

        $campos[] = $form->chosen('pessoaDocumentoTipoCod', 'Tipo do documento', true)
                ->setValor($form->retornaValor('pessoaDocumentoTipoCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('6')
                ->setTabela('pessoa_documento_tipo')
                ->setCampoCod('pessoaDocumentoTipoCod')
                ->setOrdena(false)
                ->setWhere('pessoaTipo LIKE "F" AND pessoaDocumentoTipoReferenciaCod IS NULL')
                ->setComplemento('onclick="getCampos(\'pessoaDocumentoTipoCod\',\'pessoaDocumentoCamposDinamicos\',\'getCamposDocumentos\',\''.$cod.'\');"')
                ->setCampoDesc('pessoaDocumentoTipoNome');       

        $campos[] = $form->layout('void', $html->abreTagAberta('div', array('class' => 'col-sm-12')).$html->fechaTag('div'));
        $campos[] = $form->layout('campos', $html->abreTagAberta('div', array('id' => 'pessoaDocumentoCamposDinamicos')).$html->fechaTag('div'));

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }    

    public function getFormManuContato($acao, $cod = null)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao($acao);

        $nomeForm = 'formManuContato' . $cod;
        
        $form->config($nomeForm, 'POST')
                ->setHeader('Contatos');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('pessoaContatoTipoCod', 'Tipo', true)
                ->setValor($form->retornaValor('pessoaContatoTipoCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('4')
                ->setTabela('pessoa_contato_tipo')
                ->setCampoCod('pessoaContatoTipoCod')
                ->setOrdena(false)
                ->setCampoDesc('pessoaContatoTipoNome');       

        $campos[] = $form->texto('pessoaContatoNome', 'Contato', true)
                ->setEmColunaDeTamanho('7')
                ->setValor($form->retornaValor('pessoaContatoNome'));                          

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }   

    public function getObjetoCampos($param, $cod, $codForm)
    {     

        $form = new \Pixel\Form\Form();
        $pessoaFisicaClass = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaClass();

        $campo = '';
        $buffer = '';

        $form->setAcao('sisAlterarPadrao($(form).attr("name"),true)');
        $form->config('formManuDocumento'.$codForm);

        while($data = $param->fetch()) {            
          
            switch ($data['pessoadocumentotipocampo']) {

                case 'select':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoadocumentotipocod'], 'select');
                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;                                  
                        
                    $campos[] = $form->chosen('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setTabela($rel['pessoadocumentotiporelacionamentotabelanome'])
                            ->setCampoCod($rel['pessoadocumentotiporelacionamentotabelachave'])
                            ->setCampoDesc($rel['pessoadocumentotiporelacionamentotabelacolunanome'])
                            ->setInicio('Selecione...')
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']))
                            ->setMultiplo(false)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setLayoutPixel(true)
                            ->setOrdena(false);                           				

                break;

                case 'suggest':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoadocumentotipocod'], 'select');
                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;
                        
                    $campos[] = $form->suggest('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setTabela($rel['pessoadocumentotiporelacionamentotabelanome'])
                            ->setCampoCod($rel['pessoadocumentotiporelacionamentotabelachave'])
                            ->setCampoDesc($rel['pessoadocumentotiporelacionamentotabelacolunanome'])
                            ->setPlaceHolder('Pesquisar...')
                            //->setValor(\filter_input(INPUT_POST, '_pCod'))
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']))
                            ->setHiddenValue(true)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setLayoutPixel(true);        

                break;                

                case 'texto':

                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->texto('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']));                                                                     

                break;

                case 'data':

                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->data('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']));                                                                    

                break;       

                case 'cpf':

                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->cpf('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']));                                                                      

                break;     

                case 'upload':

                    $campos[] = $form->upload('pessoaDocumentoTipoCod' . $cod . '[]', $data['pessoadocumentotiponome'], "ARQUIVO")
                            ->setCodigoReferencia($data['pessoadocumentotiporeferenciacod'])
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setMultiple(true);                                                                     

                break;                                                       
                
            }      

        }

        $campos[] = $form->hidden('pessoaDocumentoTipoCod')
                ->setValor($cod);  
				
        $campos[] = $form->hidden('cod')
                ->setValor($codForm);  				

        $formCampos = $form->processarForm($campos);

        return $formCampos;             

    }

    public function getFormCampos($param, $cod, $codForm)
    {

        $form = new \Pixel\Form\Form();
        $pessoaFisicaClass = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaClass();

        $campo = '';
        $buffer = '';

        $form->setAcao('sisAlterarPadrao($(form).attr("name"),true)');
        $form->config('formManuDocumento'.$codForm);

        //print_r($param);

        while($data = $param->fetch()) {

            //print_r($data);

            switch ($data['pessoadocumentotipocampo']) {

                case 'select':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoadocumentotipocod'], 'select');
                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoadocumentotipocod'], $codForm);   					

					$campos[] = $form->hidden('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'])
							->setValor($valor); 							
					
					$formHidden = $form->processarForm($campos);
					$campoHidden  = $formHidden->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']);  				
                        
                    $campos[] = $form->chosen('pessoaDocumentoTipoCod' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setTabela($rel['pessoadocumentotiporelacionamentotabelanome'])
                            ->setCampoCod($rel['pessoadocumentotiporelacionamentotabelachave'])
                            ->setCampoDesc($rel['pessoadocumentotiporelacionamentotabelacolunanome'])
                            ->setInicio('Selecione...')
                            ->setValor($valor)
                            ->setMultiplo(false)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setLayoutPixel(true)
							->setComplemento('onchange="setValue(\'pessoaDocumentoTipoCod'. $data['pessoadocumentotipocod'] .'\', \'pessoaDocumentoTipoCod_'. $data['pessoadocumentotipocod'] .'\');"')
                            ->setOrdena(false);

                    $formSelect = $form->processarForm($campos);
                    $campoSelect  = $formSelect->getFormHtml('pessoaDocumentoTipoCod' . $data['pessoadocumentotipocod']);
					$campoSelect .= $formSelect->javaScript()->getLoad(true); 							      
                    $buffer .= $campoHidden . $campoSelect;                 

                break;

                case 'suggest':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoadocumentotipocod'], 'select');
                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;

                    $valor = $pessoaFisicaClass->getValor($data['pessoadocumentotipocod'], $codForm, 'suggest');
                    $valorId = $pessoaFisicaClass->getValor($data['pessoadocumentotipocod'], $codForm);             
                        
                    $campos[] = $form->suggest('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setTabela($rel['pessoadocumentotiporelacionamentotabelanome'])
                            ->setCampoCod($rel['pessoadocumentotiporelacionamentotabelachave'])
                            ->setCampoDesc($rel['pessoadocumentotiporelacionamentotabelacolunanome'])
                            ->setPlaceHolder('Pesquisar...')
                            ->setValor($valor)
                            ->setAtributos(['_pCod' => $valorId])
                            ->setHiddenValue('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'])
                            ->setEmColunaDeTamanho('6')
                            ->setLayoutPixel(true);

                    $formCampos = $form->processarForm($campos);
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']);
                    $campo .= $formCampos->javaScript()->getLoad(true);         
                    $buffer .= $campo;                 

                break;                

                case 'texto':

                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoadocumentotipocod'], $codForm);  

                    $campos[] = $form->texto('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setValor($valor); 

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']);                 
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;

                case 'data':

                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoadocumentotipocod'], $codForm);  

                    $campos[] = $form->data('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setValor($valor); 

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']);   
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;       

                case 'cpf':

                    $obrigatorio = ($data['pessoadocumentotipocampoobrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoadocumentotipocod'], $codForm);  

                    $campos[] = $form->cpf('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod'], $data['pessoadocumentotiponome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setValor($valor);                             

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoadocumentotipocod']);   
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;     

                case 'upload':

                    $campos[] = $form->upload('pessoaDocumentoTipoCod' . $cod . '[]', $data['pessoadocumentotiponome'], "ARQUIVO")
                            ->setCodigoReferencia($data['pessoadocumentotiporeferenciacod'])
                            ->setEmColunaDeTamanho('6')
                            ->setAtributos(['_pCod' => $data['pessoadocumentotipocod']])
                            ->setMultiple(true);                    

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod' . $cod . '[]');   
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;                                                       
                
            }      

        }
		
        return $buffer;

    }    

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();                

        return $jsStatic->getFunctions($jsStatic->setFunctions($this->getMeuJS()));
    }

    private function getMeuJS()
    {

        /*
        ** var a => recebe a id do campo que invocou o evento
        ** var b => recebe o elemento que sofrerá update
        ** var c => recebe o metodo
        ** var d => recebe o cod em edicao
        */
        $buffer  = '';   
        $buffer .= 'function getCampos(a,b,c,d){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa+"&d="+d, dataType: "json", beforeSend: function() {
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';  
        $buffer .= 'function setValue(a,b){
						$("#"+b).val($("#"+a).val());
                    }';		
        $buffer .= 'function getController(a,b,c){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';                                        			
        return $buffer;

    }

}
