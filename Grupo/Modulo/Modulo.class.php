<?php

namespace Sappiens\Grupo\Modulo;

class Modulo
{
    /**
     * 
     * @return Form
     */
    public function getFormModulo()
    {
        $form = new \Zion\Form\Form();
        
        $form->config('Form1', 'GET')
                ->setClassCss('smart-form')
                ->setNovalidate(true)
                ->setHeader('Standard Form Header do cavalo amarelo')
                ->setTarget('_blank')
                ->setAction('recebe.php');
        
        $campos[] = $form->texto('nome','Nome',true)
                ->setId('nome2')
                ->setPlaceHolder('Nome')
                ->setIconFA('fa-user')
                ->setToolTipMsg('&nbsp;&nbsp;Qualquer informação de ajuda&nbsp;')
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('nome'))
                ->setIdentifica('Nome da Pessoa');
        
        $campos[] = $form->texto('sobrenome','Sobrenome')
                ->setPlaceHolder('Sobrenome')
                ->setIconFA('fa-user')
                ->setToolTipMsg('&nbsp;&nbsp;Qualquer informação de ajuda&nbsp;')
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('Sobrenome'))
                ->setIdentifica('Nome da Pessoa');
        
        $campos[] = $form->email('email','E-mail')
                ->setPlaceHolder('E-mail')
                ->setIconFA('fa-envelope')                
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('email'))
                ->setIdentifica('Email');
        
        $campos[] = $form->escolha()
                ->setNome('sexo')
                ->setIdentifica('Sexo')                
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('sexo'))
                ->setInicio(true)
                ->setArray(array('M'=>'Masculinox','F'=>'Feminino'));
        
        $campos[] = $form->data('data','Data')
                ->setPlaceHolder('Selecione uma data')                
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('data'));
        
        $campos[] = $form->suggest('cidade', 'Cidades')
                ->setTabela('cidade')                
                ->setCampoDesc('CidadeNome')                                  
                ->setPlaceHolder('Informe o nome da sua cidade preferida...')
                ->setEmColunaDeTamanho(6);
        
        $campos[] = $form->botaoSubmit('enviar','Enviar')
                ->setClassCss('btn btn-primary');
        
        return $form->processarForm($campos);        
    }
}