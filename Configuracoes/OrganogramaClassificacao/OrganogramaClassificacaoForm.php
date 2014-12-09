<?php

namespace Sappiens\Configuracoes\OrganogramaClassificacao;

class OrganogramaClassificacaoForm
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

            case 'organogramaClassificacaoReferenciaCod':
                
            $campos[] = $form->chosen('organogramaClassificacaoReferenciaCod', 'Classificação precedente', true)
                    //->setArray($param)
                    ->setInicio('Selecione...')
                    ->setTabela('organograma_classificacao')
                    ->setMultiplo(false)
                    ->setEmColunaDeTamanho('12')
                    ->setLayoutPixel(false)
                    ->setOrdena(false)
                    ->setWhere("INSTR(organogramaClassificacaoAncestral,CONCAT('|', ".$_SESSION['OrganogramaClassificacaoCod'].",'|')) > 0")
                    ->setComplemento('onclick="chNxt(\'#organogramaClassificacaoReferenciaCod\',\'#labelAntes_organogramaClassificacaoNome\',\'organogramaClassificacaoOrdem\',\'getOrdem\');"')
                    //->setCampoDesc('IF(organogramaClassificacaoOrdem != "",CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoReferenciaCombinado), organogramaClassificacaoNome)');                     
                    ->setCampoDesc('CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoNome)');  

            break;
            
        }

        return $form->processarForm($campos);

    }    

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $cod = null)
    {
        $form = new \Pixel\Form\Form();
        $acesso = new \Zion\Acesso\Acesso();
        $chTipoClas = $acesso->permissaoAcao('chTipoClas');

        $organogramaClassificacaoReferenciaCod = '';
        $organogramaClassificacaoOrdem = '[...]';

        $con = \Zion\Banco\Conexao::conectar();
        $sql = new \Sappiens\Configuracoes\OrganogramaClassificacao\OrganogramaClassificacaoSql();
        $getDadosOrganograma = $con->execLinhaArray($sql->getDadosOrganogramaByOrganogramaCod($_SESSION['organogramaCod']));        

        if($acao == 'alterar') {

            $getDados = $con->execLinhaArray($sql->getDadosSql($cod));  
            $organogramaClassificacaoReferenciaCod = $getDados['organogramaClassificacaoReferenciaCod'];
            $organogramaClassificacaoOrdem = $getDados['organogramaClassificacaoOrdem'];

        }

        $form->setAcao($acao);

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Classificação do Organograma');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        if($chTipoClas) {

            $campos[] = $form->chosen('organogramaClassificacaoTipoCod', 'Tipo de Classificação', true)
                    ->setValor($form->retornaValor('organogramaClassificacaoTipoCod'))
                    ->setInicio('Selecione...')
                    ->setMultiplo(false)
                    ->setEmColunaDeTamanho('12')
                    ->setTabela('organograma_classificacao_tipo')
                    ->setCampoCod('organogramaClassificacaoTipoCod')
                    ->setOrdena(false)
                    //->setComplemento('onclick="chChosen(\'#organogramaClassificacaoTipoCod\',\'#sisContainerOrganogramaClassificacaoReferenciaCod\',\'getOrganogramaClassificacaoReferenciaCod\');"')
                    ->setCampoDesc('organogramaClassificacaoTipoNome');  

        }           

                /*
                ** Campo-fantasma de getFormManuPhantom
                */
                $organogramaClassificacaoCod = $getDadosOrganograma['organogramaClassificacaoCod'];
        $campos[] = $form->chosen('organogramaClassificacaoReferenciaCod', 'Classificação precedente', true)
                ->setValor($form->retornaValor('organogramaClassificacaoReferenciaCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('organograma_classificacao')
                ->setCampoCod('organogramaClassificacaoCod')
                ->setOrdena(false)
                ->setContainer('sisContainerOrganogramaClassificacaoReferenciaCod')
                //->setDisabled(($acao == "alterar" ? 'false' : true))
                ->setWhere("INSTR(organogramaClassificacaoAncestral,CONCAT('|', " . $organogramaClassificacaoCod . ",'|')) > 0")
                ->setComplemento('onclick="chNxt(\'#organogramaClassificacaoReferenciaCod\',\'#labelAntes_organogramaClassificacaoNome\',\'organogramaClassificacaoOrdem\',\'getOrdem\');"')
                //->setCampoDesc('IF(organogramaClassificacaoOrdem != "",CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoReferenciaCombinado), organogramaClassificacaoNome)');    
                ->setCampoDesc('CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoNome)');               

        $campos[] = $form->hidden('organogramaClassificacaoOrdem')
                ->setValor($form->retornaValor('organogramaClassificacaoOrdem'));                 

        $campos[] = $form->texto('organogramaClassificacaoNome', 'Classificação', true)
                ->setLabelAntes($organogramaClassificacaoOrdem)
                ->setValor($form->retornaValor('organogramaClassificacaoNome'));    

        $campos[] = $form->escolha('organogramaClassificacaoReordenavel', 'Tipo de classificação reordenável', true)
                ->setValor($form->retornaValor('organogramaClassificacaoReordenavel'))
                ->setValorPadrao('N')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(['S' => 'Sim', 'N' => 'Não']);    

        $campos[] = $form->escolha('organogramaClassificacaoStatus', 'Status', true)
                ->setValor($form->retornaValor('organogramaClassificacaoStatus'))
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

        return $jsStatic->getFunctions();
    }

}
