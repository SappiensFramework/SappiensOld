<?php

namespace Sappiens\Dashboard;

class DashboardForm
{

    /**
     * 
     * @return Form
     */
    public function getFormPesquisarOrganograma()
    {

        $form = new \Pixel\Form\Form();

        $form->config('FormOrganograma', 'GET')
                ->setNovalidate(true);

        $con = \Zion\Banco\Conexao::conectar();
        $sql = new \Sappiens\Dashboard\DashboardSql();
        $getDadosOrganograma = $con->execLinhaArray($sql->getDadosOrganograma($_SESSION['organogramaCod']));
        $organogramaNome = $getDadosOrganograma['organogramaNome'];
        //$getDadosUsuario = $con->execLinhaArray($sql->getDadosUsuario($_SESSION['usuarioCod']));          
        //$organogramaCodUsuario = $getDadosUsuario['organogramaCod'];

        $campos[] = $form->suggest('organograma', 'organograma', false)
                ->setTabela('organograma')
                ->setCampoCod('organogramaCod')
                ->setCampoDesc('organogramaNome')
                ->setClassCss('clearfix')
                ->setPlaceHolder($organogramaNome)
                ->setCondicao("e INSTR(organogramaAncestral,CONCAT(:|:," . $_SESSION['organogramaCod'] . ",:|:)) > 0")
                ->setHiddenValue('organogramaCod')
                ->setOnSelect('getController(\'organogramaCod\', \'organograma\', \'setOrganogramaCod\')')
                ->setLayoutPixel(false);

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
        $buffer .= 'function getController(a,b,c){
                        var aa = $("#"+a).val();
                        $.ajax({type: "get", url: "'.SIS_URL_BASE.'Dashboard?acao="+c+"&a="+aa, dataType: "json", beforeSend: function() {
                            $("#"+b).html(\'<i class="fa fa-refresh fa-spin" style="margin-top:10px;"></i>\');
                        }}).done(function (ret) {
                            $("#"+b).html(ret.retorno);
                            location.reload();
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
        return $buffer;

    }

}
