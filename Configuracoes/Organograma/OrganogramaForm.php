<?php

namespace Sappiens\Configuracoes\Organograma;

class OrganogramaForm
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
    public function getFormManu($acao, $cod = null, $extra = null)
    {
        $class = new \Sappiens\Configuracoes\Organograma\OrganogramaClass();
        $form = new \Pixel\Form\Form();
        $acesso = new \Zion\Acesso\Acesso();
        $chOrg = $acesso->permissaoAcao('chOrg');

        $organogramaReferenciaCod = $form->retornaValor('organogramaReferenciaCod');
        $organogramaClassificacaoTipoCod = '';
        $organogramaOrdem = '[...]';

        $con = \Zion\Banco\Conexao::conectar();
        $sql = new \Sappiens\Configuracoes\Organograma\OrganogramaSql();
        $getDados = $con->execLinhaArray($sql->getDadosSql(($acao == "cadastrar") ? $_SESSION['organogramaCod'] : $cod));        

        if($acao == 'alterar') {

            $organogramaReferenciaCod = $getDados['organogramaReferenciaCod'];
            $getDadosClassificacaoTipo = $con->execLinhaArray($sql->getOrganogramaClassificacaoTipoCodByOrganogramaClassificacaoCod($getDados['organogramaClassificacaoCod']));
            $organogramaClassificacaoTipoCod = $getDadosClassificacaoTipo['organogramaClassificacaoTipoCod'];
            $organogramaOrdem = $getDados['organogramaOrdem'];

        }

        $form->setAcao($acao);

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Configuração do Organograma');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('organogramaReferenciaCod', 'Classificação precedente', false)
                ->setValor($organogramaReferenciaCod)
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('organograma a, organograma_classificacao b')
                ->setCampoCod('organogramaCod')
                ->setOrdena(true)
                ->setWhere("INSTR(a.organogramaAncestral,CONCAT('|', " . $_SESSION['organogramaCod'] . ",'|')) > 0 AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod")
                //->setComplemento('onclick="getClassificacaoReordenavel(\'organogramaReferenciaCod\', \'sisFormIdorganogramaClassificacaoTipoCod\',\'getClassificacaoReordenavel\');"')
                ->setComplemento('onclick="getClassificacaoReordenavel(\'organogramaReferenciaCod\', \'sisFormIdorganogramaClassificacaoTipoCod\',\'getClassificacaoReordenavel\');chNxt(\'#organogramaReferenciaCod\',\'#labelAntes_organogramaNome\',\'organogramaOrdem\',\'getOrdem\');"')
                //->setCampoDesc('CONCAT(organogramaOrdem, " - ", organogramaReferenciaCombinado)');    
                //->setCampoDesc('CONCAT(organogramaNome, " - ", organogramaReferenciaCombinado)');
                ->setCampoDesc('CONCAT(organogramaOrdem, " - ", organogramaNome, " [", b.organogramaClassificacaoNome,"]")');


        if($acao == 'cadastrar' or ($acao == 'alterar' and $class->getClassificacaoReordenavel($getDados['organogramaCod']))) {
            if($chOrg) {

                $campos[] = $form->hidden('organogramaOrdem')
                        ->setValor($form->retornaValor('organogramaOrdem'));        

                $campos[] = $form->chosen('organogramaClassificacaoTipoCod', 'Tipo de Classificação', false)
                        ->setValor($organogramaClassificacaoTipoCod)
                        ->setInicio('Selecione...')
                        ->setMultiplo(false)
                        ->setEmColunaDeTamanho('12')
                        ->setTabela('organograma_classificacao_tipo')
                        ->setCampoCod('organogramaClassificacaoTipoCod')
                        ->setOrdena(false)
                        ->setComplemento('onclick="chChosen(\'#organogramaClassificacaoTipoCod\',\'#sisContainerOrganogramaClassificacaoCod\',\'getOrganogramaClassificacaoCod\');"')
                        ->setCampoDesc('organogramaClassificacaoTipoNome');    

            }
        }

                        /*
                        ** Campo-fantasma de getFormManuPhantom
                        */
                        $organogramaClassificacaoCod = $getDados['organogramaClassificacaoCod'];
                $campos[] = $form->chosen('organogramaClassificacaoCod', 'Classificação', true)
                        ->setValor($form->retornaValor('organogramaClassificacaoCod'))
                        ->setContainer('sisContainerOrganogramaClassificacaoCod')
                        ->setInicio('Selecione...')
                        ->setMultiplo(false)
                        ->setEmColunaDeTamanho('12')
                        ->setTabela('organograma_classificacao')
                        ->setCampoCod('organogramaClassificacaoCod')
                        ->setWhere("INSTR(organogramaClassificacaoAncestral,CONCAT('|', " . $organogramaClassificacaoCod . ",'|')) > 0")
                        ->setOrdena(false)
                        //->setDisabled(($acao == "cadastrar" ? 'false' : true))
                        ->setCampoDesc('organogramaClassificacaoNome');   

            //}   
        //}                               

        $campos[] = $form->texto('organogramaNome', 'Posição', true)
                ->setLabelAntes($organogramaOrdem)
                //->setLabelDepois('*')
                ->setValor($form->retornaValor('organogramaNome'));    

        $campos[] = $form->escolha('organogramaOrdenavel', 'Seguir ordenação', true)
                ->setValor($form->retornaValor('organogramaOrdenavel'))
                ->setValorPadrao('A')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(['A' => 'Ativo','I' => 'Inativo']);               

        $campos[] = $form->escolha('organogramaStatus', 'Status', true)
                ->setValor($form->retornaValor('organogramaStatus'))
                ->setValorPadrao('A')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(['A' => 'Ativo', 'I' => 'Inativo']);                       

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
        return $buffer;

    }

}
