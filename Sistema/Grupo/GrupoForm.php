<?php

namespace Sappiens\Sistema\Grupo;

class GrupoForm
{

    public function getFormFiltro()
    {
        $form = new \Pixel\Form\FormFiltro();    
        
        $form->config('sisFormFiltro');
        
        $campos[] = $form->suggest('grupoNome', 'Modulo','')
                ->setTabela('_grupo')
                ->setCampoBusca('grupoNome')
                ->setCampoDesc('grupoNome');

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
                ->setHeader('Grupos');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->texto('grupoNome', 'Nome', true)
                ->setMaximoCaracteres(50)
                ->setValor($form->retornaValor('grupoNome'));

        $campos[] = $form->texto('grupoPacote', 'Diretório', true)
                ->setMaximoCaracteres(50)
                ->setValor($form->retornaValor('grupoPacote'));
        
        $campos[] = $form->numero('grupoPosicao', 'Posição', true)
                ->setValorMaximo(99)
                ->setValorMinimo(1)
                ->setValor($form->retornaValor('grupoPosicao'));

        $campos[] = $form->texto('grupoClass', 'Icone', true)
                ->setMaximoCaracteres(30)
                ->setToolTipMsg('Deve conter o nome da classe do repositório do Bootstrap ou Fontes Awesome')
                ->setIconFA('fa-font')
                ->setValor($form->retornaValor('grupoClass'));          

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();

        $mudaPosicao = $jQuery->ajax()
                ->getJSON()
                ->setUrl('?acao=mudaPosicao')
                ->setData("{'grupoCod':grupoCod,'maisMenos':maisMenos}")
                ->setFuncao('mudaPosicao(grupoCod, maisMenos)')
                ->setDone("if (ret.sucesso === 'true') { $('#grupoPosicao'+grupoCod).html(ret.retorno); } else { sisSetCrashAlert('Erro', ret.retorno); }")
                ->setFail('sisMsgFailPadrao();')
                ->criar();

        $jsStatic->setFunctions($mudaPosicao);

        return $jsStatic->getFunctions();
    }

}
