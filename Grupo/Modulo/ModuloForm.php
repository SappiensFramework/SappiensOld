<?php

namespace Sappiens\Grupo\Modulo;

class ModuloForm
{

    public function getModuloFormFiltro()
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

    public function getModuloForm()
    {
        $form = new \Pixel\Form\Form();

        $cod = $form->retornaValor('cod');

        $form->config('formManu' . $cod, 'POST')
                ->setNovalidate(true)
                ->setHeader('Estados');

        $campos[] = $form->hidden('cod')
                ->setValor($cod);

        $campos[] = $form->texto('ufSigla', 'Sigla da Unidade Federativa', true)
                ->setMaximoCaracteres(2)
                ->setMinimoCaracteres(2)
                ->setValor($form->retornaValor('ufSigla'));

        $campos[] = $form->texto('ufNome', 'Nome da Unidade Federativa', false)
                ->setMaximoCaracteres(100)
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->numero('ufIbgeCod', 'Código do IBGE', true)
                ->setValor($form->retornaValor('ufNome'))
                ->setMaximoCaracteres(10)
                ->setValor($form->retornaValor('ufIbgeCod'));

        $campos[] = $form->botaoSubmit('enviar', 'Salvar')
                ->setClassCss('btn btn-primary');

        $campos[] = $form->botaoReset('limpar', 'Limpar')
                ->setClassCss('btn btn-default');

        return $form->processarForm($campos);
    }

    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        $jQuery = new \Zion\JQuery\JQuery();

        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->get()
                        ->setUrl('?acao=filtrar')
                        ->setDataType('json')
                        ->setData('p')
                        ->setDone(' $("#sisContainerGrid").html(ret.retorno); ')
                        ->setFuncao('sisFiltrar(p)')
                        ->criar());

        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->get()
                        ->setUrl('?acao=cadastrar')
                        ->setDataType('json')
                        ->setDone(' $("#sisContainerManu").html(ret.retorno); ')
                        ->setFuncao('sisCadastrarLayout()')
                        ->criar());

        $jsStatic->setFunctions(
                $jQuery->ajax()
                        ->post()
                        ->setUrl('?acao=cadastrar')
                        ->setDataType('json')
                        ->setDone(' $("#sisContainerManu").html(ret.retorno); ')
                        ->setFuncao('cadastrar()')
                        ->criar());

        return $jsStatic->getFunctions();
    }

}
