<?php

namespace Sappiens\dashboard;

class Smart
{
    /**
     * 
     * @return Form
     */
    public function getFormSmart()
    {
        $form = new \Zion\Form\Form();
/*        
        $form->config()
                ->setMethod('GET')
                ->setNome('Form1')  
                ->setClassCss('navbar-form pull-left')
                ->setNovalidate(true)
                ->setTarget('_blank')
                ->setAction('recebe.php');
        
        $campos[] = $form->texto()
                ->setNome('nome')
                ->setId('nome2')
                ->setClassCss('form-control')
                ->setPlaceHolder('Pesquisar')
                ->setValor($form->retornaValor('nome'));
        /*
        $campos[] = $form->botaoSubmit()
                ->setNome('enviar')
                ->setClassCss('btn btn-primary')
                ->setValor('Enviar');
        */
        //return $form->processarForm($campos);        
    }
}