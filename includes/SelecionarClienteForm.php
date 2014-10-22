<?php

namespace Sappiens\includes;

class SelecionarClienteForm
{

    /**
     * 
     * @return Form
     */
    public function getFormModulo()
    {
        $form = new \Pixel\Form\Form();
/*
        $form->config('Form1', 'GET')
                ->setNovalidate(true)
                //->setHeader('Selecionar cliente')
                ->setClassCss('navbar-form pull-left')
                ->setTarget('_blank')
                ->setAction('recebe.php');
*/
        $campos[] = $form->suggest('v_uf_cidade', 'Cidades2', false)
                ->setTabela('v_uf_cidade')
                ->setCampoCod('UfCidadeCod')
                ->setCampoDesc('UfCidadeNomeUfNome')
                ->setPlaceHolder('Pesquisar...')
                //->setClassCss('navbar-form')
                ->setHiddenValue('UfCidadeCod')
                ->setLayoutPixel(false);
                //->setEmColunaDeTamanho(12);
/*
          $campos[] = $form->botaoSubmit('enviar', 'Continuar')
          ->setClassCss('btn btn-primary'); 
          
          $campos[] = $form->botaoReset('limpar', 'Limpar')
          ->setClassCss('btn btn-default'); 
*/
        return $form->processarForm($campos);
    }

}
