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

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Inicial');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

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
                //->setValorPadrao('M')
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

        $campos[] = $form->chosen('pessoaDocumentoTipoCod', 'Tipo do documento', true)
                ->setValor($form->retornaValor('pessoaContatoTipoCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('10')
                ->setTabela('pessoa_documento_tipo')
                ->setCampoCod('pessoaDocumentoTipoCod')
                ->setOrdena(false)
                ->setWhere('pessoaTipo LIKE "F" AND pessoaDocumentoTipoReferenciaCod IS NULL')
                ->setComplemento('onclick="getCampos(\'pessoaDocumentoTipoCod\',\'pessoaDocumentoCamposDinamicos\',\'getCamposDocumentos\',\''.$cod.'\');"')
                ->setCampoDesc('pessoaDocumentoTipoNome');       

        $campos[] = $form->layout('campos', $html->abreTagAberta('div', array('id' => 'pessoaDocumentoCamposDinamicos')).$html->fechaTag('div'));

/*        $campos[] = $form->texto('pessoaDocumentoNome', 'Documento', true)
                ->setEmColunaDeTamanho('10')
                ->setValor($form->retornaValor('pessoaDocumentoNome'));                          
*/
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

    public function getFormCampos($param, $codForm)
    {

        $form = new \Pixel\Form\Form();
        $pessoaFisicaClass = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaClass();

        $campo = '';
        $buffer = '';

        $form->config('formManuDocumento'.$codForm);

        while($data = $param->fetch_array()) {

            switch ($data['pessoaDocumentoTipoCampo']) {

                case 'select':

                    $rel = $pessoaFisicaClass->getRelacionamento($data['pessoaDocumentoTipoCod']);
                        
                    $campos[] = $form->chosen($rel['pessoaDocumentoTipoRelacionamentoTabelaChave'], $data['pessoaDocumentoTipoNome'], true)
                            ->setTabela($rel['pessoaDocumentoTipoRelacionamentoTabelaNome'])
                            ->setCampoCod($rel['pessoaDocumentoTipoRelacionamentoTabelaChave'])
                            ->setCampoDesc($rel['pessoaDocumentoTipoRelacionamentoTabelaColunaNome'])
                            ->setInicio('Selecione...')
                            ->setMultiplo(false)
                            ->setEmColunaDeTamanho('5')
                            ->setLayoutPixel(true)
                            ->setOrdena(false);

                    $formCampos = $form->processarForm($campos);
                    $campo  = $formCampos->getFormHtml($rel['pessoaDocumentoTipoRelacionamentoTabelaChave']);
                    $campo .= $formCampos->javaScript()->getLoad(true);         
                    $buffer .= $campo;                 

                break;

                case 'input':

                    $campos[] = $form->texto($data['pessoaDocumentoTipoNome'], $data['pessoaDocumentoTipoNome'], true)
                            ->setEmColunaDeTamanho('5')
                            ->setValor($form->retornaValor($data['pessoaDocumentoTipoNome']));  

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml($data['pessoaDocumentoTipoNome']);   
                    $campo .= $formCampos->javaScript()->getLoad(true);    
                    $buffer .= $campo;                                                                        

                break;

                case 'date':
/*
                    $campos[] = $form->data('pessoaFisicaDataNascimento', 'Data de nascimento', false)
                            ->setEmColunaDeTamanho('6')
                            ->setValor($form->retornaValor('pessoaFisicaDataNascimento'));                 
*/
                    $campos[] = $form->data('pessoaDocumentoTipoNome', $data['pessoaDocumentoTipoNome'], true)
                            ->setEmColunaDeTamanho('5')
                            ->setValor($form->retornaValor($data['pessoaDocumentoTipoNome']));  

                    $formCampos = $form->processarForm($campos);    
                    $campo  = $formCampos->getFormHtml('pessoaDocumentoTipoNome');   
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
                            $("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';
/*                    
        $buffer .= 'function getClassificacaoByReferencia(a,b,c){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            $("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';                    
        $buffer .= 'function getClassificacaoReordenavel(a,b,c){ 
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            //$("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            if(ret.retorno === true) {
                                //alert(ret.retorno);
                                $("#"+b).removeClass("hidden");                                                       
                            } else {
                                //alert(ret.retorno);
                                //getClassificacaoTipo(a,\'sisContainerOrganogramaClassificacaoCod\',\'getOrganogramaClassificacaoTipoCod\');
                                getClassificacaoByReferencia(a,\'sisContainerOrganogramaClassificacaoCod\',\'getOrganogramaClassificacaoByReferencia\');
                                $("#"+b).addClass("hidden");   
                            }
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';
*/                    
        return $buffer;

    }

}
