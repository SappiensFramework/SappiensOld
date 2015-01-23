<?php

namespace Sappiens\GestaoAdministrativa\Categoria;

class CategoriaForm
{

    private $class;

    public function __construct()
    {
        $this->class = new CategoriaClass();
    }
    
    public function getFormFiltro()
    {
        $form = new \Pixel\Form\Form();

        $form->config('sisFormFiltro');

        $campos[] = $form->chosen('websiteDomCod', 'Domínio do Website')
                ->setTabela('website_dom')
                ->setCampoCod("websiteDomCod")
                ->setCampoDesc('websiteDom')
                ->setAliasSql("a");

        $campos[] = $form->texto('websiteConCat', 'Categoria');

        return $form->processarForm($campos);
    }

    /**
     * 
     * @return \Pixel\Form\Form
     */
    public function getFormManu($acao, $cod = null)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao($acao);

        $nomeForm = 'formManu' . $cod;
        
        $form->config($nomeForm, 'POST')
                ->setHeader('Domínios');

        $campos[] = $form->hidden('cod')
                ->setValor($form->retornaValor('cod'));

        $campos[] = $form->chosen('organogramaCod', 'Órgão', false)
                ->setValor($form->retornaValor('organogramaCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('organograma a, organograma_classificacao b')
                ->setCampoCod('campoCod')
                ->setOrdena(false)
                ->setSqlCompleto("SELECT a.organogramaCod AS campoCod, IF(a.organogramaOrdem != \"\",CONCAT(a.organogramaOrdem, \" - \", a.organogramaNome, \" [\", b.organogramaClassificacaoNome,\"]\"), a.organogramaNome) AS campoDesc
                                    FROM organograma a, organograma_classificacao b 
                                   WHERE INSTR(a.organogramaAncestral,CONCAT('|', " . $_SESSION['organogramaCod'] . ",'|')) > 0 
                                     AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod
                                ORDER BY a.organogramaOrdem")
                ->setCampoDesc('campoDesc');

        $campos[] = $form->chosen('websiteDomCod', 'Domínio do Website', true)
                         ->setValor($form->retornaValor('websiteDomCod'))
                         ->setArray([])
                         ->setEmColunaDeTamanho('12')
                         ->setDependencia('organogramaCod', 'getDominiosOrganogramaCod', __CLASS__);

        $campos[] = $form->texto('websiteConCat', 'Categoria', false)
                ->setMaximoCaracteres(50)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('websiteConCat'));

        $campos[] = $form->escolha('websiteConCatStatus', 'Status', true)
                ->setValor($form->retornaValor('websiteConCatStatus'))
                ->setArray(['A' => "Ativo", "I" => "Inativo"])
                ->setEmColunaDeTamanho('12');

        $campos[] = $form->botaoSalvarPadrao();

        $campos[] = $form->botaoDescartarPadrao();

        return $form->processarForm($campos);
    }
    
    public function getJSEstatico()
    {
        $jsStatic = \Pixel\Form\FormJavaScript::iniciar();

        //$jQuery = new \Zion\JQuery\JQuery();        

        return $jsStatic->getFunctions();
    }

    public function getDominiosOrganogramaCod($organogramaCod)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao("cadastrar");

        $dominios = $this->class->getDominiosOrganogramaCod($organogramaCod);
        
        $doms = array();
        
        if(is_array($dominios)){

            foreach($dominios as $dominio){
                $doms[$dominio['websitedomcod']] = $dominio['websitedom'];
            }

        }

        $campos[0] = $form->chosen('websiteDomCod', 'Domínios')
                ->setValor($form->retornaValor('websiteDomCod'))
                ->setArray($doms);

        return $form->processarForm($campos);
    }

}
