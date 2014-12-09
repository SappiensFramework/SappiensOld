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

    public function getFormManuPhantom($param, $campo)
    {

        $form = new \Pixel\Form\Form();

        switch ($campo) {

            case 'organogramaClassificacaoCod':
                
            $campos[] = $form->chosen('organogramaClassificacaoCod', 'Classificação', true)
                    ->setArray($param)
                    ->setInicio('Selecione...')
                    ->setMultiplo(false)
                    ->setEmColunaDeTamanho('12')
                    ->setLayoutPixel(false)
                    ->setOrdena(false);

            break;
            
        }

        return $form->processarForm($campos);

    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManuTab($acao, $cod = null, $extra = null)
    {

        $form = new \Pixel\Form\Form();
        $acesso = new \Zion\Acesso\Acesso();     
        $template = new \Pixel\Template\Template();   

        $tabArray = array(
            array('tabId' => 1,
                  'tabActive' => 'active',
                  'tabTitle' => 'Titulo da tab 1', 
                  'tabContent' => $this->getFormManu($acao, $cod, $extra)
                  ),
            array('tabId' => 2,
                  'tabActive' => 'none',
                  'tabTitle' => 'Titulo da tab 2', 
                  'tabContent' => 'tab2'
                  )            
        );

        return $template->getTab('tabWelcome', ['classCss' => 'col-sm-6'], $tabArray);

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
                ->setHeader('Cadastro de pessoa física');

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
/*
        $campos[] = $form->escolha('organogramaStatus', 'Status', true)
                ->setValor($form->retornaValor('organogramaStatus'))
                ->setValorPadrao('A')
                ->setEmColunaDeTamanho('6')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(['A' => 'Ativo', 'I' => 'Inativo']);                       
*/
        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao('formManu' . $cod);          
        
        return $form->processarForm($campos);
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
        */
        $buffer  = '';
/*        
        $buffer .= 'function getClassificacaoTipo(a,b,c){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            $("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                        }).fail(function () {
                            sisMsgFailPadrao();
                        });  
                    }';
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
