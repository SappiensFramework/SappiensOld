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

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $cod = null)
    {
        $form = new \Pixel\Form\Form();

        $organogramaClassificacaoReferenciaCod = '';
        $organogramaClassificacaoOrdem = '[...]';

        if($acao == 'alterar') {

            $con = \Zion\Banco\Conexao::conectar();
            $sql = new \Sappiens\Configuracoes\OrganogramaClassificacao\OrganogramaClassificacaoSql();
            $getDados = $con->execLinhaArray($sql->getDadosSql($cod));
            $organogramaClassificacaoReferenciaCod = $getDados['organogramaClassificacaoReferenciaCod'];
            $organogramaClassificacaoOrdem = $getDados['organogramaClassificacaoOrdem'];

        }

        $form->setAcao($acao);

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Classificação do Organograma');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('organogramaClassificacaoReferenciaCod', 'Classificação precedente', true)
                ->setValor($form->retornaValor('organogramaClassificacaoReferenciaCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                //->setSelecaoMinima(1)
                //->setSelecaoMaxima(1)
                //->setValorPadrao([$organogramaClassificacaoReferenciaCod])
                ->setEmColunaDeTamanho('12')
                ->setTabela('v_organograma_classificacao')
                ->setCampoCod('organogramaClassificacaoCod')
                ->setOrdena(false)
                ->setComplemento('onclick="chNxt(\'#organogramaClassificacaoReferenciaCod\',\'#labelAntes_organogramaClassificacaoNome\',\'organogramaClassificacaoOrdem\',\'getOrdem\');"')
                ->setCampoDesc('CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoReferenciaCombinado)');    
                //->setCampoDesc('CONCAT(organogramaClassificacaoOrdem, " - ", organogramaClassificacaoNome)');

        $campos[] = $form->hidden('organogramaClassificacaoOrdem')
                ->setValor($form->retornaValor('organogramaClassificacaoOrdem'));                 

        $campos[] = $form->texto('organogramaClassificacaoNome', 'Classificação', true)
                ->setLabelAntes($organogramaClassificacaoOrdem)
                ->setValor($form->retornaValor('organogramaClassificacaoNome'));    

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
