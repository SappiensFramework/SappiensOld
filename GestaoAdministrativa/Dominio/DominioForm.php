<?php

namespace Sappiens\GestaoAdministrativa\Dominio;

class DominioForm
{

    private $class;

    public function __construct()
    {
        $this->class = new DominioClass();
    }
    
    public function getFormFiltro()
    {
        $form = new \Pixel\Form\Form();

        $form->config('sisFormFiltro');

        $campos[] = $form->suggest('websiteDom', 'Domínio do Website')
                ->setTabela('website_dom')
                ->setCampoBusca('websiteDom')
                ->setCampoDesc('websiteDom');

        $campos[] = $form->suggest('websiteDomNomeAbreviado', 'Nome do Website')
                ->setTabela('website_dom')
                ->setCampoBusca('websiteDomNomeAbreviado')
                ->setCampoDesc('websiteDomNomeExtenso');

        $campos[] = $form->suggest('websiteDomPalavrasChave', 'Palavras Chave do Website')
                ->setTabela('website_dom')
                ->setCampoBusca('websiteDomPalavrasChave')
                ->setCampoDesc('websiteDomNomeExtenso');

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

        $campos[] = $form->texto('websiteDomNomeAbreviado', 'Nome Abreviado do Website', false)
                ->setMaximoCaracteres(50)
                ->setValor($form->retornaValor('websiteDomNomeAbreviado'));

        $campos[] = $form->texto('websiteDomNomeExtenso', 'Nome Extenso do Website', false)
                ->setMaximoCaracteres(255)
                ->setValor($form->retornaValor('websiteDomNomeExtenso'));

        $campos[] = $form->texto('websiteDom', 'Domínio do Website', true)
                ->setMaximoCaracteres(255)
                ->setMinimoCaracteres(5)
                ->setValor($form->retornaValor('websiteDom'));

        $campos[] = $form->texto('websiteDomEmail', 'Email do Website', true)
                ->setMaximoCaracteres(255)
                ->setMinimoCaracteres(5)
                ->setValor($form->retornaValor('websiteDomEmail'));

        $campos[] = $form->textArea('websiteDomDescricao', 'Descrição do Website', true)
                ->setValor($form->retornaValor('websiteDomDescricao'))
                ->setLinhas(6);

        $campos[] = $form->textArea('websiteDomPalavrasChave', 'Palavras-chave do Website', true)
                ->setValor($form->retornaValor('websiteDomPalavrasChave'))
                ->setLinhas(6);

        $campos[] = $form->escolha('websiteDomPublicar', 'Publicar Website', true)
                ->setValor($form->retornaValor('websiteDomPublicar'))
                ->setArray(['S' => "Sim", "N" => "Não"]);

        $campos[] = $form->escolha('websiteDomStatus', 'Status', true)
                ->setValor($form->retornaValor('websiteDomStatus'))
                ->setArray(['A' => "Ativo", "I" => "Inativo"]);

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

}
