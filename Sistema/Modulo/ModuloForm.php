<?php

namespace Sappiens\Sistema\Modulo;

class ModuloForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\Form();

        $form->config('sisFormFiltro');

        $campos[] = $form->suggest('moduloNome', 'Modulo')
                ->setTabela('_modulo')
                ->setCampoBusca('moduloNome')
                ->setCampoDesc('moduloNome')
                ->setAliasSql('a');

        $campos[] = $form->escolha('grupoCod', 'Grupo')
                ->setTabela('_grupo')
                ->setCampoCod('grupoCod')
                ->setCampoDesc('grupoNome')
                ->setAliasSql('b');

        $campos[] = $form->escolha('moduloVisivelMenu', 'Visivel no menu?')
                ->setTabela('_grupo')
                ->setArray(['S' => 'Sim', 'N' => 'Não'])
                ->setAliasSql('a');

        $campos[] = $form->numero('moduloPosicao', 'Posição')
                ->setAliasSql('a');

        return $form->processarForm($campos);
    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $formCod = null)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao($acao);

        $form->config('formManu' . $formCod, 'POST')
                ->setHeader('Modulos');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('grupoCod', 'Grupo', true)
                ->setTabela('_grupo')
                ->setCampoCod('grupoCod')
                ->setCampoDesc('grupoNome')
                ->setValor($form->retornaValor('grupoCod'));

        $campos[] = $form->chosen('moduloCodReferente', 'Módulo de Referência', false)
                ->setArray([]) //fake input
                ->setInicio('Sem referência')
                ->setDependencia('grupoCod', 'getFormModulo', __CLASS__)
                ->setValor($form->retornaValor('moduloCodReferente'));

        $campos[] = $form->texto('moduloNome', 'Nome do Módulo', true)
                ->setMaximoCaracteres(70)
                ->setValor($form->retornaValor('moduloNome'));

        $campos[] = $form->texto('moduloNomeMenu', 'Nome no Menu', true)
                ->setMaximoCaracteres(50)
                ->setValor($form->retornaValor('moduloNomeMenu'));

        $campos[] = $form->textArea('moduloDesc', 'Descrição do Módulo', true)
                ->setMaximoCaracteres(250)
                ->setLinhas(4)
                ->setValor($form->retornaValor('moduloDesc'));

        $campos[] = $form->escolha('moduloVisivelMenu', 'Será visivel no menu?', true)
                ->setExpandido(true)
                ->setOrdena(false)
                ->setArray(['S' => 'Sim', 'N' => 'Não'])
                ->setValor($form->retornaValor('moduloVisivelMenu'));

        $campos[] = $form->numero('moduloPosicao', 'Posição', true)
                ->setValorMaximo(99)
                ->setValorMinimo(1)
                ->setValor($form->retornaValor('moduloPosicao'));

        $campos[] = $form->escolha('moduloBase', 'Módulo Base')
                ->setInicio('Nenhum')
                ->setArray(['Sistema' => 'Sistema'])
                ->setValor($form->retornaValor('moduloBase'));

        $campos[] = $form->texto('moduloClass', 'Icone')
                ->setMaximoCaracteres(30)
                ->setToolTipMsg('Deve conter o nome da classe do repositório do Bootstrap ou Fontes Awesome')
                ->setIconFA('fa-font')
                ->setValor($form->retornaValor('moduloClass'));

        
        $objPai = new \Pixel\Form\Form();
        $objPai->setAcao($acao);
        
        $campos[] = $form->masterDetail('acoes','Ações do módulo')
                ->setTabela('_acao_modulo')
                ->setCampoReferencia('moduloCod')
                ->setCodigoReferencia($formCod)
                ->setObjetoPai($objPai)
                ->setTotalItensInicio(3)
                ->setAddMin(0)
                ->setCampos([
            'acaoModuloPermissao' => $objPai->texto('acaoModuloPermissao', 'Permissão', true)
            ->setEmColunaDeTamanho(6),
            'acaoModuloIdPermissao' => $objPai->texto('acaoModuloIdPermissao', 'Id da Permissão', true)
            ->setEmColunaDeTamanho(6),
            'acaoModuloIcon' => $objPai->texto('acaoModuloIcon', 'Ícone', true)
            ->setEmColunaDeTamanho(6),
            'acaoModuloToolTipComPermissao' => $objPai->texto('acaoModuloToolTipComPermissao', 'Tooltip com Permissão', false)
            ->setEmColunaDeTamanho(6),
            'acaoModuloToolTipeSemPermissao' => $objPai->texto('acaoModuloToolTipeSemPermissao', 'Tooltip sem Permissão', false)
            ->setEmColunaDeTamanho(6),
            'acaoModuloFuncaoJS' => $objPai->texto('acaoModuloFuncaoJS', 'Função JS', true)
            ->setEmColunaDeTamanho(6),
            'acaoModuloPosicao' => $objPai->numero('acaoModuloPosicao', 'Posição', true)
            ->setEmColunaDeTamanho(6),
            'acaoModuloApresentacao' => $objPai->chosen('acaoModuloApresentacao', 'Apresentação', true)
            ->setEmColunaDeTamanho(6)
            ->setArray(['E' => 'Expandido', 'R' => 'Recolhido', 'I' => 'Acao invisivel'])]
        );        

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }

    public function getFormModulo($referenciaCod)
    {
        $form = new \Pixel\Form\Form();

        $campos[] = $form->escolha('moduloCodReferente', 'Módulo de Referência')
                ->setInicio('Sem referência')
                ->setTabela('_modulo')
                ->setCampoCod('moduloCod')
                ->setCampoDesc('moduloNome')
                ->setWhere("grupoCod = $referenciaCod");

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();

        $mudaPosicao = $jQuery->ajax()
                ->getJSON()
                ->setUrl('?acao=mudaPosicao')
                ->setData("{'moduloCod':moduloCod,'maisMenos':maisMenos}")
                ->setFuncao('mudaPosicao(moduloCod, maisMenos)')
                ->setDone("if (ret.sucesso === 'true') { $('#moduloPosicao'+moduloCod).html(ret.retorno); } else { sisSetCrashAlert('Erro', ret.retorno); }")
                ->setFail('sisMsgFailPadrao();')
                ->criar();

        $jsStatic->setFunctions($mudaPosicao);

        return $jsStatic->getFunctions();
    }

}
