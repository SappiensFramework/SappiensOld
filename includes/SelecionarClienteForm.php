<?php
/*

    Sappiens Framework
    Copyright (C) 2014, BRA Consultoria

    Website do autor: www.braconsultoria.com.br/sappiens
    Email do autor: sappiens@braconsultoria.com.br

    Website do projeto, equipe e documentação: www.sappiens.com.br
   
    Este programa é software livre; você pode redistribuí-lo e/ou
    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
    publicada pela Free Software Foundation, versão 2.

    Este programa é distribuído na expectativa de ser útil, mas SEM
    QUALQUER GARANTIA; sem mesmo a garantia implícita de
    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
    detalhes.
 
    Você deve ter recebido uma cópia da Licença Pública Geral GNU
    junto com este programa; se não, escreva para a Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
    02111-1307, USA.

    Cópias da licença disponíveis em /Sappiens/_doc/licenca

*/

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
