<?php
/**
*
*    Sappiens Framework
*    Copyright (C) 2014, BRA Consultoria
*
*    Website do autor: www.braconsultoria.com.br/sappiens
*    Email do autor: sappiens@braconsultoria.com.br
*
*    Website do projeto, equipe e documentação: www.sappiens.com.br
*   
*    Este programa é software livre; você pode redistribuí-lo e/ou
*    modificá-lo sob os termos da Licença Pública Geral GNU, conforme
*    publicada pela Free Software Foundation, versão 2.
*
*    Este programa é distribuído na expectativa de ser útil, mas SEM
*    QUALQUER GARANTIA; sem mesmo a garantia implícita de
*    COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
*    PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
*    detalhes.
* 
*    Você deve ter recebido uma cópia da Licença Pública Geral GNU
*    junto com este programa; se não, escreva para a Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
*    02111-1307, USA.
*
*    Cópias da licença disponíveis em /Sappiens/_doc/licenca
*
*/

namespace Sappiens\GrupoExemplo\ModuloExemplo;

class ModuloExemploForm
{

    public function getFormFiltro()
    {

        $form = new \Pixel\Form\Form();

        $form->config('sisFormFiltro');

        $campos[] = $form->numero('ufCod', 'Código');

        $campos[] = $form->suggest('ufNome', 'Unidade Federativa')
                ->setTabela('uf')
                ->setCampoBusca('ufNome')
                ->setCampoDesc('ufNome');

        $campos[] = $form->escolha('ufSigla', 'Sigla do Estado')
                ->setTabela('uf')
                ->setCampoCod('ufSigla')
                ->setCampoDesc('ufSigla');

        $campos[] = $form->numero('ufIbgeCod', 'Código do IBGE');

        $campos[] = $form->data('aniversario', 'Aniversário do Estado');

        return $form->processarForm($campos);

    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $cod = null, $extra = null)
    {

        $form = new \Pixel\Form\Form();    

        $form->setAcao($acao);

        $nomeForm = 'formManu' . $cod;

        $form->config('formManu' . $cod, 'POST')
                ->setHeader('Título do formulário');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->texto('moduloExeNome', 'Input texto normal', true)
                ->setMaximoCaracteres(30)
                ->setValor($form->retornaValor('moduloExeNome'));   

        $campos[] = $form->cpf('moduloExeCpf', 'Input para CPF', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeCpf'));  

        $campos[] = $form->cnpj('moduloExeCnpj', 'Input para CNPJ', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeCnpj'));      

        $campos[] = $form->telefone('moduloExeTelefone', 'Input para Telefone', false)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeTelefone')); 

        $campos[] = $form->email('moduloExeEmail', 'Input para Email', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeEmail'));

        $campos[] = $form->numero('moduloExeNumero', 'Input para Numero', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeNumero'));                    

        $campos[] = $form->cep('moduloExeCep', 'Input para Cep', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeCep'));  

        $campos[] = $form->senha('moduloExeSenha', 'Input para Senha', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeSenha'));      

        $campos[] = $form->data('moduloExeData', 'Input para Data', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeData'));    

        $campos[] = $form->hora('moduloExeHora', 'Input para Hora', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeHora'));  

        $campos[] = $form->textArea('moduloExeTextArea', 'Input para Text Area', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('moduloExeTextArea'));                                                                                                                                    

        $campos[] = $form->escolha('moduloExeEscolhaSelect', 'Select simples com banco', true)
                ->setValor($form->retornaValor('moduloExeEscolhaSelect'))
                ->setEmColunaDeTamanho('12')
                ->setTabela('uf')
                ->setCampoCod('ufCod')
                ->setCampoDesc('ufNome');    

        $campos[] = $form->chosen('moduloExeChosenSimples', 'Chosen simples com banco', true)
                ->setValor($form->retornaValor('moduloExeChosenSimples'))
                //->setInicio('Selecione')
                ->setEmColunaDeTamanho('12')
                ->setMultiplo(false)
                //->setSelecaoMinima(2)
                //->setSelecaoMaxima(3)
                //->setValorPadrao([50, 51, 52])
                ->setTabela('uf')
                ->setCampoCod('ufCod')
                ->setCampoDesc('ufNome');                    

        $campos[] = $form->chosen('moduloExeChosenMultiplo[]', 'Chosen múltiplo com banco', true)
                ->setValor($form->retornaValor('moduloExeChosenMultiplo[]'))
                //->setInicio('Selecione')
                ->setEmColunaDeTamanho('12')
                ->setMultiplo(true)
                ->setSelecaoMinima(2)
                ->setSelecaoMaxima(3)
                //->setValorPadrao([50, 51, 52])
                ->setTabela('uf')
                ->setCampoCod('ufCod')
                ->setCampoDesc('ufNome');                

        $campos[] = $form->escolha('moduloExeEscolhaUm', 'Checkbox único', false)
                ->setValor($form->retornaValor('moduloExeEscolhaUm'))
                ->setMultiplo(true)
                ->setExpandido(true)
                ->setArray(array('S' => 'Aceito os termos'));      

        $campos[] = $form->escolha('moduloExeEscolhaVarios[]', 'Checkbox vários', true)
                ->setValor($form->retornaValor('moduloExeEscolhaVarios[]'))
                ->setSelecaoMinima(2)
                ->setSelecaoMaxima(3)
                ->setValorPadrao(['A', 'E'])
                ->setInLine(false)
                ->setMultiplo(true)
                ->setExpandido(true)
                ->setComplemento(['C' => 'onclick="alert(\'Mi gusta de una sacanage!\')"'])
                ->setArray([
                    'A' => 'iPhone',
                    'B' => 'iPad',
                    'C' => 'iFode (alert)',
                    'D' => 'MacBook',
                    'E' => 'AppleTV']);                              

        $campos[] = $form->escolha('moduloExeEscolhaDois', 'Radio', true)
                ->setValor($form->retornaValor('moduloExeEscolhaDois'))
                ->setValorPadrao('V')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(array(
                    'M' => 'Macho',
                    'F' => 'Femea',
                    'C' => 'Cavalo',
                    'V' => 'Vaca'));                                                  

        $campos[] = $form->upload('anexos[]', 'Meus anexos', "IMAGEM")
                ->setThumbnail(true)
                ->setAlturaMaximaTB(30)
                ->setCodigoReferencia($cod)
                ->setMultiple(true);

        $campos[] = $form->escolha('moduloExeStatus', 'Status', true)
                ->setValor($form->retornaValor('moduloExeStatus'))
                ->setValorPadrao('A')
                ->setMultiplo(false)
                ->setExpandido(true)
                ->setArray(['A' => 'Ativo', 'I' => 'Inativo']);                       

        $campos[] = $form->botaoSalvarEContinuar();

        $campos[] = $form->botaoDescartarPadrao('formManu' . $cod);              
        
        return $form->processarForm($campos);

    }

    public function getJSEstatico()
    {

        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();
        $jQuery = new \Zion\JQuery\JQuery();                

        return $jsStatic->getFunctions($jsStatic->setFunctions($this->getMeuJS()));

    }

    private function getMeuJS()
    {

        $buffer  = '';
        return $buffer;

    }

}
