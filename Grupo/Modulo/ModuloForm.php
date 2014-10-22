<?php

namespace Sappiens\Grupo\Modulo;

class ModuloForm
{
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
        
        
        $campos[] = $form->numero('UfIbgeCod', 'Código do IBGE',true)
                ->setValor($form->retornaValor('Cod'))
                ->setMaximoCaracteres(10);               

        $campos[] = $form->botaoSubmit('enviar', 'Enviar')
                ->setClassCss('btn btn-primary');

        $campos[] = $form->botaoReset('limpar', 'Limpar')
                ->setClassCss('btn btn-default');

        return $form->processarForm($campos);
    }

}
