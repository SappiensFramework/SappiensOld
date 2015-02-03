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

namespace Sappiens\Configuracoes\Bairro;

class BairroForm
{

    private $class;

    public function __construct()
    {

        $this->class = new BairroClass();

    }    

    public function getFormFiltro()
    {

        $form = new \Pixel\Form\FormFiltro();

        $form->config('sisFormFiltro');

            $campos[] = $form->suggest('ufCidadeNome', 'Cidade', 'b')
                             ->setValor($form->retornaValor('ufCidadeNome'))
                             ->setTabela('uf_cidade')
                             ->setCampoDesc('ufCidadeNome')
                             ->setCampoBusca('ufCidadeNome')
                             ->setCampoCod('ufCidadeCod');

        $campos[] = $form->texto('ufCidadeBairroNome', 'Bairro', 'a')
                         ->setMaximoCaracteres(255)
                         ->setValor($form->retornaValor('ufCidadeBairroNome'));

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
             ->setHeader('Configurações de bairros');

        $campos[] = $form->hidden('cod')
                         ->setValor($form->retornaValor('cod'));

        $disabled = ($acao == "cadastrar" ? false : true);
        
        $campos[] = $form->chosen('ufCod', 'Estado', !$disabled)
                         ->setValor($form->retornaValor('ufCod'))
                         ->setTabela('uf')
                         ->setCampoCod('ufCod')
                         ->setDisabled($disabled)
                         ->setCampoDesc('ufNome');
        
        $campos[] = $form->chosen('ufCidadeCod', 'Cidade', true)
                         ->setValor($form->retornaValor('ufCidadeCod'))
                         ->setArray([])
                         ->setDependencia('ufCod', 'getCidadeEstadoFiltro', __CLASS__);

        $campos[] = $form->texto('ufCidadeBairroNome', 'Bairro', true)
                         ->setMaximoCaracteres(100)
                         ->setValor($form->retornaValor('ufCidadeBairroNome'));     

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
    
    public function getCidadeEstadoFiltro($ufCod)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao("alterar");

        $cidades = $this->class->getCidadeEstadoFiltro($ufCod);
        
        $values = array();
        
        if(is_array($cidades)){

            foreach($cidades as $cidade){
                $values[$cidade['ufcidadecod']] = $cidade['ufcidadenome'];
            }

        }

        $campos[0] = $form->chosen('ufCidadeCod', 'Cidade')
                ->setValor($form->retornaValor('ufCidadeCod'))
                ->setArray($values);

        return $form->processarForm($campos);

    }
    
    public function getBairroCidadeFiltro($ufCidadeCod)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao("alterar");

        $bairros = $this->class->getBairroCidadeFiltro($ufCidadeCod);
        
        $values = array();
        
        if(is_array($bairros)){

            foreach($bairros as $bairro){
                $values[$bairro['ufcidadebairrocod']] = $bairro['ufcidadebairronome'];
            }

        }

        $campos[0] = $form->chosen('ufCidadeBairroCod', 'Bairro')
                ->setValor($form->retornaValor('ufCidadeBairroCod'))
                ->setArray($values);

        return $form->processarForm($campos);
    }

}
