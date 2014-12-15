<?php

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

        $campos[] = $form->botaoSubmit('enviar', 'Enviar')
                ->setClassCss('btn btn-primary');

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

        $form->setAcao($acao);

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

        $form->config('formManuDocumento'.$codForm);

        while($data = $param->fetch_array()) {            
          
            switch ($data['pessoaDocumentoTipoCampo']) {

                case 'select':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoaDocumentoTipoCod'], 'select');
                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;                                  
                        
                    $campos[] = $form->chosen('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setTabela($rel['pessoaDocumentoTipoRelacionamentoTabelaNome'])
                            ->setCampoCod($rel['pessoaDocumentoTipoRelacionamentoTabelaChave'])
                            ->setCampoDesc($rel['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'])
                            ->setInicio('Selecione...')
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']))
                            ->setMultiplo(false)
                            ->setEmColunaDeTamanho('6')
                            ->setLayoutPixel(true)
                            ->setOrdena(false);                           				

                break;

                case 'suggest':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoaDocumentoTipoCod'], 'select');
                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;
                        
                    $campos[] = $form->suggest('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setTabela($rel['pessoaDocumentoTipoRelacionamentoTabelaNome'])
                            ->setCampoCod($rel['pessoaDocumentoTipoRelacionamentoTabelaChave'])
                            ->setCampoDesc($rel['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'])
                            ->setPlaceHolder('Pesquisar...')
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']))
                            ->setHiddenValue('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'])
                            ->setEmColunaDeTamanho('6')
                            ->setLayoutPixel(true);        

                break;                

                case 'texto':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->texto('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']));                                                                     

                break;

                case 'data':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->data('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']));                                                                    

                break;       

                case 'cpf':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->cpf('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setValor(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']));                                                                      

                break;     

                case 'upload':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->upload('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], "IMAGEM")
                            ->setCodigoReferencia(\filter_input(INPUT_POST, 'pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']))
                            ->setEmColunaDeTamanho('6')
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

        $form->config('formManuDocumento'.$codForm);

        while($data = $param->fetch_array()) {

            switch ($data['pessoaDocumentoTipoCampo']) {

                case 'select':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoaDocumentoTipoCod'], 'select');
                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoaDocumentoTipoCod'], $codForm);   					

					$campos[] = $form->hidden('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'])
							->setValor($valor); 							
					
					$formHidden = $form->processarForm($campos);
					$campoHidden  = $formHidden->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);  				
                        
                    $campos[] = $form->chosen('pessoaDocumentoTipoCod' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setTabela($rel['pessoaDocumentoTipoRelacionamentoTabelaNome'])
                            ->setCampoCod($rel['pessoaDocumentoTipoRelacionamentoTabelaChave'])
                            ->setCampoDesc($rel['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'])
                            ->setInicio('Selecione...')
                            ->setValor($valor)
                            ->setMultiplo(false)
                            ->setEmColunaDeTamanho('6')
                            ->setLayoutPixel(true)
							->setComplemento('onchange="setValue(\'pessoaDocumentoTipoCod'. $data['pessoaDocumentoTipoCod'] .'\', \'pessoaDocumentoTipoCod_'. $data['pessoaDocumentoTipoCod'] .'\');"')
                            ->setOrdena(false);

                    $formSelect = $form->processarForm($campos);
                    $campoSelect  = $formSelect->getFormHtml('pessoaDocumentoTipoCod' . $data['pessoaDocumentoTipoCod']);
					$campoSelect .= $formSelect->javaScript()->getLoad(true); 							      
                    $buffer .= $campoHidden . $campoSelect;                 

                break;

                case 'suggest':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoaDocumentoTipoCod'], 'select');
                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;

                    $valor = $pessoaFisicaClass->getValor($data['pessoaDocumentoTipoCod'], $codForm, 'suggest');
                        
                    $campos[] = $form->suggest('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setTabela($rel['pessoaDocumentoTipoRelacionamentoTabelaNome'])
                            ->setCampoCod($rel['pessoaDocumentoTipoRelacionamentoTabelaChave'])
                            ->setCampoDesc($rel['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'])
                            ->setPlaceHolder('Pesquisar...')
                            ->setValor($valor)
                            ->setHiddenValue('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'])
                            ->setEmColunaDeTamanho('6')
                            ->setLayoutPixel(true);

                    $formCampos = $form->processarForm($campos);
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);
                    $campo .= $formCampos->javaScript()->getLoad(true);         
                    $buffer .= $campo;                 

                break;                

                case 'texto':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoaDocumentoTipoCod'], $codForm);  

                    $campos[] = $form->texto('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setValor($valor); 

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);                 
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;

                case 'data':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoaDocumentoTipoCod'], $codForm);  

                    $campos[] = $form->data('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setValor($valor); 

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);   
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;       

                case 'cpf':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;
                    $valor = $pessoaFisicaClass->getValor($data['pessoaDocumentoTipoCod'], $codForm);  

                    $campos[] = $form->cpf('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], $obrigatorio)
                            ->setEmColunaDeTamanho('6')
                            ->setValor($valor);                             

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);   
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;     

                case 'upload':

                    $obrigatorio = ($data['pessoaDocumentoTipoCampoObrigatorio'] == 'S') ? true : false;

                    $campos[] = $form->upload('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod'], $data['pessoaDocumentoTipoNome'], "IMAGEM")
                            ->setCodigoReferencia($cod)
                            ->setEmColunaDeTamanho('6')
                            ->setMultiple(true);                    

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoCod_' . $data['pessoaDocumentoTipoCod']);   
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
        return $buffer;

    }

}
