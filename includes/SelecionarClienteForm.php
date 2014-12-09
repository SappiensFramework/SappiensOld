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

        $form->config('Form1', 'GET')
                ->setNovalidate(true);
                //->setHeader('Selecionar cliente')
                //->setClassCss('navbar-form pull-left')
                //->setTarget('_blank')
                //->setAction('recebe.php');

        $campos[] = $form->suggest('organograma', 'organograma', false)
                ->setTabela('organograma')
                ->setCampoCod('organogramaCod')
                ->setCampoDesc('organogramaNome')
                ->setPlaceHolder('Pesquisar...')
                ->setCondicao("e INSTR(organogramaAncestral,CONCAT(:|:," . $_SESSION['organogramaCod'] . ",:|:)) > 0")
                ->setHiddenValue('organogramaCod')
                ->setOnSelect('javascript:alert("asd");')
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
