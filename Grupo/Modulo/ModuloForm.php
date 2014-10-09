<?php

namespace Sappiens\Grupo\Modulo;

class ModuloForm
{

    /**
     * 
     * @return Form
     */
    public function getFormModulo()
    {
        $form = new \Pixel\Form\Form();

        $form->config('Form1', 'GET')
                ->setNovalidate(true)
                ->setHeader('Standard Form Header do cavalo amarelo')
                ->setTarget('_blank')
                ->setAction('recebe.php');

        $campos[] = $form->texto('nome', 'Nome da Pessoa', true)
                ->setId('nome2')
                ->setPlaceHolder('digite o nome aqui')
                ->setClassCss('form-control')
                ->setIconFA('fa-user')
                ->setToolTipMsg('&nbsp;&nbsp;Qualquer informação de ajuda&nbsp;')
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('nome'));

        $campos[] = $form->texto('sobrenome', 'Sobrenome')
                ->setPlaceHolder('Sobrenome')
                ->setClassCss('form-control')
                ->setIconFA('fa-user')
                ->setToolTipMsg('&nbsp;&nbsp;Qualquer informação de ajuda&nbsp;')
                ->setEmColunaDeTamanho(6)
                ->setValor($form->retornaValor('Sobrenome'))
                ->setIdentifica('Nome da Pessoa');

        $campos[] = $form->suggest('cidade', 'Cidades')
                ->setTabela('cidade')
                ->setCampoDesc('CidadeNome')
                ->setPlaceHolder('Informe o nome da sua cidade preferida...')
                ->setEmColunaDeTamanho(6);
        
        $campos[] = $form->senha('senha', 'Digite a Senha')
                ->setEmColunaDeTamanho(6)
                ->setIconFA('fa-key')
                ->setPlaceHolder('Coloque sua Senha aqui!');

        $campos[] = $form->data('data', 'Data de Nascimento', true)
                ->setEmColunaDeTamanho(6)
                ->setPlaceHolder('Informe a data corretamnete');

        $campos[] = $form->hora('hora', 'Hora do dia')
                ->setEmColunaDeTamanho(6)
                ->setPlaceHolder('Coloque a hora');
        /*
          $campos[] = $form->email('email', 'E-mail')
          ->setPlaceHolder('E-mail')
          ->setClassCss('form-control')
          ->setIconFA('fa-envelope')
          ->setEmColunaDeTamanho(6)
          ->setValor($form->retornaValor('email'))
          ->setIdentifica('Email');

          $campos[] = $form->escolha()
          ->setNome('sexo')
          ->setIdentifica('Sexo')
          ->setClassCss('form-control')
          ->setEmColunaDeTamanho(6)
          ->setValor($form->retornaValor('sexo'))
          ->setInicio(true)
          ->setArray(array('M' => 'Masculinox', 'F' => 'Feminino'));

          $campos[] = $form->data('data', 'Data')
          ->setPlaceHolder('Selecione uma data')
          ->setClassCss('form-control')
          ->setEmColunaDeTamanho(6)
          ->setValor($form->retornaValor('data')); */

        /*
          $campos[] = $form->botaoSubmit('enviar', 'Enviar')
          ->setClassCss('btn btn-primary'); */

        return $form->processarForm($campos);
    }

}
