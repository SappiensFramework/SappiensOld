<?php

namespace Sappiens\GestaoAdministrativa\Conteudo;

class ConteudoForm
{

    private $class;

    public function __construct()
    {
        $this->class = new ConteudoClass();
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

        $campos[] = $form->texto('websiteConTitulo', 'Título do Conteúdo')
                         ->setAliasSql("a");

        $campos[] = $form->data('websiteConData', 'Data de Publicação', false)
                         ->setAliasSql("a");

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

        $campos[] = $form->chosen('organogramaCod', 'Órgão', true)
                ->setValor($form->retornaValor('organogramaCod'))
                ->setInicio('Selecione...')
                ->setMultiplo(false)
                ->setEmColunaDeTamanho('12')
                ->setTabela('organograma a, organograma_classificacao b')
                ->setCampoCod('campoCod')
                ->setOrdena(false)
                ->setSqlCompleto("SELECT a.organogramaCod AS campoCod, IF(a.organogramaOrdem != \"\",CONCAT(a.organogramaOrdem, \" - \", a.organogramaNome, \" [\", b.organogramaClassificacaoNome,\"]\"), a.organogramaNome) AS campoDesc
                                    FROM organograma a, organograma_classificacao b 
                                   WHERE INSTR(a.organogramaAncestral, CONCAT('|', " . $_SESSION['organogramaCod'] . ",'|')) > 0 
                                     AND a.organogramaClassificacaoCod = b.organogramaClassificacaoCod
                                ORDER BY a.organogramaOrdem")
                ->setCampoDesc('campoDesc');

        $campos[] = $form->chosen('websiteDomCod', 'Domínio do Website', true)
                         ->setValor($form->retornaValor('websiteDomCod'))
                         ->setArray([])
                         ->setEmColunaDeTamanho('12')
                         ->setDependencia('organogramaCod', 'getDominiosOrganogramaCod', __CLASS__);

        $campos[] = $form->chosen('websiteConCatCod', 'Categoria do Conteúdo', true)
                         ->setValor($form->retornaValor('websiteConCatCod'))
                         ->setArray([])
                         ->setEmColunaDeTamanho('12')
                         ->setDependencia('websiteDomCod', 'getCategoriasWebsiteDomCod', __CLASS__);

        $campos[] = $form->chosen('websiteConReferenteCod', 'Conteúdo de Referência', false)
                         ->setValor($form->retornaValor('websiteConReferenteCod'))
                         ->setArray([])
                         ->setEmColunaDeTamanho('12')
                         ->setDependencia('websiteConCatCod', 'getConteudoReferenteCod', __CLASS__);

        $campos[] = $form->texto('websiteConTitulo', 'Título do Conteúdo', true)
                ->setMaximoCaracteres(255)
                ->setValor($form->retornaValor('websiteConTitulo'));

        $campos[] = $form->textArea('websiteConDescricao', 'Descrição do Conteúdo', true)
                ->setValor($form->retornaValor('websiteConDescricao'))
                ->setLinhas(6);

        $campos[] = $form->editor('websiteCon', 'Conteúdo', true)
                ->setEmColunaDeTamanho('12')
                ->setValor($form->retornaValor('websiteCon'));
                
        $campos[] = $form->upload('files[]', 'Arquivos', "ARQUIVO")
                ->setCodigoReferencia($cod)
                ->setMultiple(true);

        $campos[] = $form->data('websiteConData', 'Data de Publicação', false)
                         ->setValor($form->retornaValor('websiteConData'))
                         ->setEmColunaDeTamanho('12');
        
        $campos[] = $form->numero('websiteConPrioridade', 'Prioridade na listagem', true)
                 ->setValor($form->retornaValor('websiteConPrioridade'))
                 ->setMaximoCaracteres(2)
                 ->setvalorMinimo(0)
                 ->setValorMaximo(99)
                 ->setEmColunaDeTamanho('12');

        $campos[] = $form->escolha('websiteConStatus', 'Status', true)
                ->setValor($form->retornaValor('websiteConStatus'))
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

    public function getCategoriasWebsiteDomCod($websiteDomCod)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao("cadastrar");

        $categorias = $this->class->getCategoriasWebsiteDomCod($websiteDomCod);
        
        $cats = array();
        
        if(is_array($categorias)){

            foreach($categorias as $categoria){
                $cats[$categoria['websiteconcatcod']] = $categoria['websiteconcat'];
            }

        }

        $campos[0] = $form->chosen('websiteConCatCod', 'Categoria do Conteúdo')
                ->setValor($form->retornaValor('websiteConCatCod'))
                ->setArray($cats);

        return $form->processarForm($campos);
    }
    
    public function getConteudoReferenteCod($websiteConCatCod)
    {
        $form = new \Pixel\Form\Form();

        $form->setAcao("cadastrar");

        $referencias = $this->class->getConteudoReferenteCod($websiteConCatCod);
        
        $refs = array();
        
        if(is_array($referencias)){

            foreach($referencias as $referencia){
                $refs[$referencia['websiteconcod']] = $referencia['websitecontitulo'];
            }

        }

        $campos[0] = $form->chosen('websiteConReferenteCod', 'Conteúdo de Referência')
                ->setValor($form->retornaValor('websiteConReferenteCod'))
                ->setArray($refs);

        return $form->processarForm($campos);
    }
}
