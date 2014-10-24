<?php

namespace Sappiens\Grupo\Modulo;

class ModuloForm
{

    public function getModuloFormFiltro()
    {
        $form = new \Pixel\Form\Form();

        $form->config('Form', 'GET')
                ->setNovalidate(true)
                ->setHeader('Estados');

        $campos[] = $form->texto('UfSigla', 'Sigla da Unidade Federativa', true)
                ->setMaximoCaracteres(2)
                ->setMinimoCaracteres(2)
                ->setValor($form->retornaValor('Cod'));
        
        return $form->processarForm($campos);
    }

    public function getModuloForm()
    {
        $form = new \Pixel\Form\Form();

        $form->config('Form', 'POST')
                ->setNovalidate(true)
                ->setHeader('Estados');

        $campos[] = $form->hidden('Cod')
                ->setValor($form->retornaValor('Cod'));

        $campos[] = $form->texto('UfSigla', 'Sigla da Unidade Federativa', true)
                ->setMaximoCaracteres(2)
                ->setMinimoCaracteres(2)
                ->setValor($form->retornaValor('Cod'));

        $campos[] = $form->texto('UfNome', 'Nome da Unidade Federativa', false)
                ->setMaximoCaracteres(100)
                ->setValor($form->retornaValor('Cod'));

        $campos[] = $form->numero('UfIbgeCod', 'Código do IBGE', true)
                ->setValor($form->retornaValor('Cod'))
                ->setMaximoCaracteres(10);

        $campos[] = $form->botaoSubmit('enviar', 'Enviar')
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
        
        return $jsStatic->getFunctions();
    }

}
