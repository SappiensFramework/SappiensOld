<?php

namespace Sappiens\Grupo\Modulo;

class ModuloForm
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

        $form->setAcao($acao);

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Estados');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->texto('ufSigla', 'Sigla da Unidade Federativa', true)
                ->setMaximoCaracteres(2)
                ->setMinimoCaracteres(2)
                ->setCaixa('ALTA')
                ->setValor($form->retornaValor('ufSigla'));

        $campos[] = $form->texto('ufNome', 'Nome da Unidade Federativa', false)
                ->setMaximoCaracteres(100)
                ->setValor($form->retornaValor('ufNome'));

        $campos[] = $form->numero('ufIbgeCod', 'Código do IBGE', true)
                ->setValor($form->retornaValor('ufNome'))
                ->setMaximoCaracteres(10)
                ->setValor($form->retornaValor('ufIbgeCod'));

        $campos[] = $form->textArea('ufTextArea', 'Descrição com TextArea', true)
                ->setValor($form->retornaValor('ufTextArea'));
        
        $campos[] = $form->textArea('ufDescricao', 'Descrição com XX', true)
                ->setValor($form->retornaValor('ufDescricao'));
        
//        $campos[] = $form->editor('ufDescricao', 'Descrição com Editor', true)
//                ->setValor($form->retornaValor('ufDescricao'))
//                ->setMaximoCaracteres(50);

        $campos[] = $form->escolha('ufEscolhaSelect', 'Select em Pixel', true)
                ->setValor($form->retornaValor('ufEscolhaSelect'))
                ->setTabela('uf')
                ->setCampoCod('ufCod')
                ->setCampoDesc('ufNome');
        
        $campos[] = $form->chosen('ufChosenSimples', 'Chosen Simples com Banco', true)
                ->setValor($form->retornaValor('ufChosenSimples'))
                ->setInicio('Selecione esse chosen amiguinho')
                ->setTabela('uf')
                ->setCampoCod('ufCod')
                ->setCampoDesc('ufNome');
        
        $campos[] = $form->chosen('ufChosenmultiplo[]', 'Chosen Multiplo com Banco', true)
                ->setValor($form->retornaValor('ufChosenmultiplo[]'))
                ->setInicio('Selecione esse chosen amiguinho')
                ->setMultiplo(true)
                ->setSelecaoMinima(2)
                ->setSelecaoMaxima(3)
                ->setValorPadrao([50,51,52])
                ->setTabela('uf')
                ->setCampoCod('ufCod')
                ->setCampoDesc('ufNome');
        

        $campos[] = $form->escolha('ufEscolhaVarios[]', 'Escolha vários', true)
                ->setValor($form->retornaValor('ufEscolhaVarios[]'))
                ->setSelecaoMinima(2)
                ->setSelecaoMaxima(3)
                ->setValorPadrao(['A', 'E'])
                ->setInLine(false)
                ->setMultiplo(true)
                ->setExpandido(true)
                ->setComplemento(['C' => 'onclick="alert(1)"'])
                ->setArray([
            'A' => 'Letra A',
            'B' => 'Letra B',
            'C' => 'Letra C',
            'D' => 'Letra D',
            'E' => 'Letra E']);

        $campos[] = $form->escolha('ufEscolhaDois', 'Escolha Dois', true)
                ->setValor($form->retornaValor('ufEscolhaDois'))
                ->setValorPadrao('V')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(array(
            'M' => 'Macho',
            'F' => 'Femea',
            'C' => 'Cavalo',
            'V' => 'Vaca'));

        $campos[] = $form->escolha('ufMarqueUm', 'Escolha Um', false)
                ->setValor($form->retornaValor('ufMarqueUm'))
                ->setMultiplo(true)
                ->setExpandido(true)
                ->setArray(array('S' => 'Aceito os termos'));

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao('formManu' . $cod);

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        //$jQuery = new \Zion\JQuery\JQuery();                

        return $jsStatic->getFunctions();
    }

}
