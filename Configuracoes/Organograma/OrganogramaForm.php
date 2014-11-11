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
        $form = new \Pixel\Form\Form();

        $organogramaReferenciaCod = '';
        $organogramaOrdem = '[...]';

        if($acao == 'alterar') {

            $con = \Zion\Banco\Conexao::conectar();
            $sql = new \Sappiens\Configuracoes\Organograma\OrganogramaSql();
            $getDados = $con->execLinhaArray($sql->getDadosSql($cod));
            $organogramaReferenciaCod = $getDados['organogramaReferenciaCod'];
            $organogramaOrdem = $getDados['organogramaOrdem'];

        }

        $form->setAcao($acao);

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Configuração do Organograma');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('organogramaReferenciaCod', 'Posição precedente', false)
                ->setValor($form->retornaValor('organogramaReferenciaCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('v_organograma')
                ->setCampoCod('organogramaCod')
                ->setOrdena(false)
                ->setComplemento('onclick="chNxt(\'#organogramaReferenciaCod\',\'#labelAntes_organogramaNome\',\'organogramaOrdem\',\'getOrdem\');"')
                //->setCampoDesc('CONCAT(organogramaOrdem, " - ", organogramaReferenciaCombinado)');    
                //->setCampoDesc('CONCAT(organogramaNome, " - ", organogramaReferenciaCombinado)');
                ->setCampoDesc('organogramaReferenciaCombinado');

        $campos[] = $form->hidden('organogramaOrdem')
                ->setValor($form->retornaValor('organogramaOrdem'));        

        $campos[] = $form->chosen('organogramaClassificacaoTipoCod', 'Tipo de Classificação', true)
                ->setValor($form->retornaValor('organogramaClassificacaoTipoCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('organograma_classificacao_tipo')
                ->setCampoCod('organogramaClassificacaoTipoCod')
                ->setOrdena(false)
                ->setComplemento('onclick="chChosen(\'#organogramaClassificacaoTipoCod\',\'#sisContainerOrganogramaClassificacaoCod\',\'getOrganogramaClassificacaoCod\');"')
                ->setCampoDesc('organogramaClassificacaoTipoNome');    

                /*
                ** Campo-fantasma de getFormManuPhantom
                */
        $campos[] = $form->chosen('organogramaClassificacaoCod', 'Classificação', true)
                ->setValor($form->retornaValor('organogramaClassificacaoTipoCod'))
                ->setContainer('sisContainerOrganogramaClassificacaoCod')
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('organograma_classificacao')
                ->setCampoCod('organogramaClassificacaoCod')
                //->setWhere(' organogramaClassificacaoCod = 0')
                ->setOrdena(false)
                ->setCampoDesc('CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoNome)');                                     

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

        return $jsStatic->getFunctions();
    }

}
