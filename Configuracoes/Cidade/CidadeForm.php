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

namespace Sappiens\Configuracoes\Cidade;

class CidadeForm
{

    private $class;

    public function __construct()
    {

        $this->class = new CidadeClass();

    }    

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
             ->setHeader('Configurações de cidades');

        $campos[] = $form->hidden('cod')
                         ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('paisCod', 'País', true)
                         ->setValor($form->retornaValor('paisCod'))
                         ->setInicio('Selecione...')
                         ->setMultiplo(false)
                         ->setEmColunaDeTamanho('12')
                         ->setTabela('pais')
                         ->setCampoCod('paisCod')
                         ->setOrdena(false)
                         ->setCampoDesc('paisNome');            

        $campos[] = $form->chosen('ufCod', 'Estado', true)
                         ->setValor($form->retornaValor('ufCod'))
                         ->setArray([])
                         ->setEmColunaDeTamanho('12')
                         ->setDependencia('paisCod', 'getUfCod', __CLASS__);                    

        $campos[] = $form->texto('ufCidadeNome', 'Cidade', true)
                         ->setMaximoCaracteres(100)
                         ->setValor($form->retornaValor('ufCidadeNome'));     

        $campos[] = $form->numero('ufCidadeIbgeCod', 'Código no IBGE', false)
                         ->setMaximoCaracteres(30)
                         ->setValor($form->retornaValor('ufCidadeIbgeCod'));   

        $campos[] = $form->numero('ufCidadeArea', 'Área', false)
                         ->setMaximoCaracteres(20)
                         ->setValor($form->retornaValor('ufCidadeArea'));                                      

        $campos[] = $form->escolha('ufCidadeStatus', 'Status', true)
                         ->setValor($form->retornaValor('ufCidadeStatus'))
                         ->setValorPadrao('A')
                         ->setMultiplo(false)
                         ->setExpandido(true)
                         ->setArray(['A' => 'Ativo', 'I' => 'Inativo']);                       

        $campos[] = $form->botaoSalvarEContinuar();

        $campos[] = $form->botaoDescartarPadrao('formManu' . $cod);              
        
        return $form->processarForm($campos);

    }

    public function getUfCod($cod)
    {

        $form = new \Pixel\Form\Form();
        $acao = \filter_input(INPUT_GET, 'acao');

        $ufs = $this->class->getUfCod($cod);
        
        $array = array();
        
        if(is_array($ufs)){

            foreach($ufs as $uf){
                $array[$uf['ufcod']] = $uf['ufnome'];
            }

        }

        if($acao == "alterar") {

            $c = \filter_input(INPUT_GET, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $ufCod = $this->class->getUfCod($c[0], 'alterar');

        } else {

            $ufCod = $form->retornaValor('ufCod');

        }

        $campos[0] = $form->chosen('ufCod', 'Estado')
                ->setValor($ufCod)
                ->setArray($array);

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
