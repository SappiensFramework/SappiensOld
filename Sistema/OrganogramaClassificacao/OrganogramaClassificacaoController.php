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

namespace Sappiens\Configuracoes\OrganogramaClassificacao;

class OrganogramaClassificacaoController extends \Zion\Core\Controller
{

    private $organogramaClassificacaoClass;
    private $organogramaClassificacaoForm;

    public function __construct()
    {
        $this->organogramaClassificacaoClass = new \Sappiens\Configuracoes\OrganogramaClassificacao\OrganogramaClassificacaoClass();
        $this->organogramaClassificacaoForm = new \Sappiens\Configuracoes\OrganogramaClassificacao\OrganogramaClassificacaoForm();
    }

    private function getFiltroNormal()
    {

        $this->html = new \Zion\Layout\Html();
        $template = new \Pixel\Template\Template();
        //$form = new \Pixel\Form\Form();

        //$form->config('formFiltro', 'GET');

        $buffer  = '';
        $buffer  = $this->html->abreTagAberta('form', array('class' => 'form-horizontal'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-group'));
        //$buffer .= $this->html->abreTagAberta('label', array('for' => 'inputFoda', 'class' => 'col-sm-2 control-label')) . 'Termo' . $this->html->fechaTag('label');
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'col-sm-6'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'input-group'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'input-group-btn'));
        $buffer .= $this->html->abreTagAberta('button', array('type' => 'button', 'class' => 'btn btn-default', 'tabindex' => '-1'));
        $buffer .= 'Fornecedor';
        $buffer .= $this->html->fechaTag('button');

        $buffer .= $this->html->abreTagAberta('button', array('id' => 'sisBtnFil', 'type' => 'button', 'class' => 'btn dropdown-toggle', 'data-toggle' => 'dropdown'));
        $buffer .= $this->html->abreTagAberta('span', array('id' =>'sisIcFil', 'class' => 'fa fa-caret-down'));
        $buffer .= '';
        $buffer .= $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('button');

        $buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' = ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'!=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' != ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:16px;', 'class' => 'italico')) . 'Diferente de' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');        

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<>\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' <> ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Menor ou maior que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' < ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Menor que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');        

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'>\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' > ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Maior que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' <= ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Menor ou igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   
        
        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'>=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' >= ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Maior ou igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');                              

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');         

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'*\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' * ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Semelhante' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');       

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'A*\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' A* ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Semelhante após' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');     

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'*A\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' *A ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Semelhante antes' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');                   

        $buffer .= $this->html->fechaTag('ul');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('input', array('id' => 'inputFoda', 'class' => 'form-control', 'onchange' => 'javascript:sisInputFil(\'sisLabel_fe\');', 'placeholder' => 'Digite e torça!'));

        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('form');
        return $buffer;

    }     

    private function getFiltroOuQue($operacao)
    {

        $this->html = new \Zion\Layout\Html();
        $template = new \Pixel\Template\Template();
        //$form = new \Pixel\Form\Form();

        //$form->config('formFiltro', 'GET');

        $buffer  = '';
        $buffer  = $this->html->abreTagAberta('form', array('class' => 'form-horizontal'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-group'));
        // por questoes de alinhamento, o primeiro campo é col-sm-5 e o segundo é col-sm-6
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'col-sm-5'));
        $buffer .= $this->getInputGroup();
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'col-sm-1'));
        $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning marE10px')) . $operacao . $this->html->fechaTag('span');       
        $buffer .= $this->html->fechaTag('div'); 
        // por questoes de alinhamento, o primeiro campo é col-sm-5 e o segundo é col-sm-6
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'col-sm-6'));
        $buffer .= $this->getInputGroup();
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('form');
        return $buffer;

    }         

    private function getInputGroup()
    {

        $buffer  = '';
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'input-group'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'input-group-btn'));
        $buffer .= $this->html->abreTagAberta('button', array('type' => 'button', 'class' => 'btn btn-default', 'tabindex' => '-1'));
        $buffer .= 'Fornecedor';
        $buffer .= $this->html->fechaTag('button');

        $buffer .= $this->html->abreTagAberta('button', array('id' => 'sisBtnFil', 'type' => 'button', 'class' => 'btn dropdown-toggle', 'data-toggle' => 'dropdown'));
        $buffer .= $this->html->abreTagAberta('span', array('id' =>'sisIcFil', 'class' => 'fa fa-caret-down'));
        $buffer .= '';
        $buffer .= $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('button');

        $buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' = ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'!=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' != ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:16px;', 'class' => 'italico')) . 'Diferente de' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');        

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<>\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' <> ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Menor ou maior que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' < ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Menor que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');        

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'>\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' > ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Maior que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' <= ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Menor ou igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   
        
        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'>=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' >= ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Maior ou igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');                              

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');         

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'*\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' * ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Semelhante' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');       

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'A*\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' A* ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Semelhante após' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');     

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'*A\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' *A ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Semelhante antes' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');                   

        $buffer .= $this->html->fechaTag('ul');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('input', array('id' => 'inputFoda', 'class' => 'form-control', 'placeholder' => 'Digite e torça!'));

        $buffer .= $this->html->fechaTag('div');
        return $buffer;

    }

    public function getFormFiltro()
    {

        $this->html = new \Zion\Layout\Html();
        $template = new \Pixel\Template\Template();

        $tabArray = array(
            array('tabId' => 1,
                  'tabActive' => 'active',
                  'tabTitle' => 'Filtros especiais' . $template->getBadge("1", ['id' => 'fE', 'tipo' => 'danger']), 
                  'tabContent' => $this->getFiltroNormal()
                  ),
            array('tabId' => 2,
                  'tabActive' => '',
                  'tabTitle' => 'Filtros de operação ' . $template->getLabel("E QUE", ['id' => 'tabEQUE', 'tipo' => 'warning']) . $template->getBadge("2", ['id' => 'fE', 'tipo' => 'danger']), 
                  'tabContent' => $this->getFiltroOuQue("E QUE")
                  ),
            array('tabId' => 3,
                  'tabActive' => '',
                  'tabTitle' => 'Filtros de operação ' . $template->getLabel("OU QUE", ['id' => 'tabOUQUE', 'tipo' => 'warning']) . $template->getBadge("1", ['id' => 'fE', 'tipo' => 'danger']), 
                  'tabContent' => $this->getFiltroOuQue("OU QUE")
                  )                
            );        

        $tab = $template->getTab('tabFiltro', array('classCss' => 'col-sm-12'), $tabArray);

        return $tab;
    }    

    protected function iniciar()
    {
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();
            $template->setConteudoIconeModulo('fa fa-yelp');
            $template->setConteudoNomeModulo('Classificação dos níveis do organograma');               

            new \Zion\Acesso\Acesso('filtrar');

            $template->setConteudoScripts($this->organogramaClassificacaoForm->getJSEstatico());

            $getBotoes = new \Pixel\Grid\GridBotoes();

            $getBotoes->setFiltros('');
            $botoes = $getBotoes->geraBotoes();

            $grid = $this->organogramaClassificacaoClass->filtrar($this->organogramaClassificacaoForm->getFormFiltro());

            $template->setTooltipForm();
            $template->setConteudoBotoes($botoes);
            $template->setConteudoGrid($grid);
        } catch (\Exception $ex) {
            
            $retorno = $ex;
        }

        $template->setConteudoMain($retorno);

        return $template->getTemplate();
    }

    protected function filtrar()
    {
        new \Zion\Acesso\Acesso('filtrar');

        return parent::jsonSucesso($this->organogramaClassificacaoClass->filtrar($this->organogramaClassificacaoForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->organogramaClassificacaoForm->getFormManu('cadastrar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm->validar();

            $this->organogramaClassificacaoClass->cadastrar($objForm);

            $retorno = 'true';
        } else {

            $retorno = $objForm->montaForm();
            $retorno.= $objForm->javaScript()->getLoad(true);
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function alterar()
    {
        new \Zion\Acesso\Acesso('alterar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm = $this->organogramaClassificacaoForm->getFormManu('alterar', \filter_input(INPUT_POST, 'cod'));

            $objForm->validar();

            $this->organogramaClassificacaoClass->alterar($objForm);

            $retorno = 'true';
        } else {

            $selecionados = \filter_input(INPUT_GET, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->organogramaClassificacaoClass->setValoresFormManu($cod, $this->organogramaClassificacaoForm);
                $retorno .= $objForm->montaForm();
                $retorno .= $objForm->javaScript()->getLoad(true);
                $objForm->javaScript()->resetLoad();
            }
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function remover()
    {
        new \Zion\Acesso\Acesso('remover');

        $selecionados = \filter_input(INPUT_POST, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $rSelecionados = count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            foreach ($selecionados as $cod) {

                $this->organogramaClassificacaoClass->remover($cod);

                $rApagados++;
            }
        } catch (\Exception $ex) {

            $mensagem[] = $ex->getMessage();
        }

        return \json_encode([
            'sucesso' => 'true',
            'selecionados' => $rSelecionados,
            'apagados' => $rApagados,
            'retorno' => \implode("\\n", $mensagem)]);
    }
    
    protected function visualizar()
    {
        new \Zion\Acesso\Acesso('visualizar');
        
        $selecionados = \filter_input(INPUT_GET, 'sisReg', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        if (!\is_array($selecionados)) {
            throw new \Exception("Nenhum registro selecionado!");
        }

        $retorno = '';
        foreach ($selecionados as $cod) {

            $objForm = $this->organogramaClassificacaoClass->setValoresFormManu($cod, $this->organogramaClassificacaoForm);
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function getOrdem()
    {
        new \Zion\Acesso\Acesso('filtrar');

        $cod = \filter_input(INPUT_GET, 'a');

        return parent::jsonSucesso($this->organogramaClassificacaoClass->getOrdem($cod));
    }

    protected function getOrganogramaClassificacaoReferenciaCod()
    {
        new \Zion\Acesso\Acesso('filtrar');
        $form = new \Sappiens\Configuracoes\OrganogramaClassificacao\OrganogramaClassificacaoForm();

        $cod = \filter_input(INPUT_GET, 'a');

        $param = $this->organogramaClassificacaoClass->getOrganogramaClassificacaoReferenciaCod($cod);    
        $formManuPhantom = $form->getFormManuPhantom($param, 'organogramaClassificacaoReferenciaCod');

        $campo  = $formManuPhantom->getFormHtml('organogramaClassificacaoReferenciaCod');
        $campo .= $formManuPhantom->javaScript()->getLoad(true); 
        return parent::jsonSucesso($campo);
    }      

/*
    private function getFiltroTamanho()
    {

        $this->html = new \Zion\Layout\Html();
        $template = new \Pixel\Template\Template();
        //$form = new \Pixel\Form\Form();

        //$form->config('formFiltro', 'GET');

        $buffer  = '';
        $buffer  = $this->html->abreTagAberta('form', array('class' => 'form-horizontal'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'form-group'));
        //$buffer .= $this->html->abreTagAberta('label', array('for' => 'inputFoda', 'class' => 'col-sm-2 control-label')) . 'Termo' . $this->html->fechaTag('label');
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'col-sm-6'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'input-group'));
        $buffer .= $this->html->abreTagAberta('div', array('class' => 'input-group-btn'));
        $buffer .= $this->html->abreTagAberta('button', array('type' => 'button', 'class' => 'btn btn-default', 'tabindex' => '-1'));
        $buffer .= 'Fornecedor';
        $buffer .= $this->html->fechaTag('button');

        $buffer .= $this->html->abreTagAberta('button', array('id' => 'sisBtnFil', 'type' => 'button', 'class' => 'btn dropdown-toggle', 'data-toggle' => 'dropdown'));
        $buffer .= $this->html->abreTagAberta('span', array('id' =>'sisIcFil', 'class' => 'fa fa-caret-down'));
        $buffer .= '';
        $buffer .= $this->html->fechaTag('span');
        $buffer .= $this->html->fechaTag('button');

        $buffer .= $this->html->abreTagAberta('ul', array('class' => 'dropdown-menu'));

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' = ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'!=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' != ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:16px;', 'class' => 'italico')) . 'Diferente de' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');        

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<>\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' <> ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Menor ou maior que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' < ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Menor que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');        

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'>\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' > ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Maior que' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'<=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' <= ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Menor ou igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   
        
        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'>=\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' >= ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Maior ou igual a' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');                              

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');         

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'*\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' * ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'recE20px italico')) . 'Semelhante' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');       

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'A*\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' A* ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Semelhante após' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');     

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'*A\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' *A ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:12px;', 'class' => 'italico')) . 'Semelhante antes' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');           

        $buffer .= $this->html->abreTagAberta('li', ['class' => 'divider']) . $this->html->fechaTag('li');         

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'E\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' E ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:20px;', 'class' => 'italico')) . 'Operador "E QUE"' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');   

        $buffer .= $this->html->abreTagAberta('li');
            $buffer .= $this->html->abreTagAberta('a', array('href' => '#', 'onclick' => 'sisChFil(\'OU\');'));
                $buffer .= $this->html->abreTagAberta('span', array('class' => 'label label-warning')) . ' OU ' . $this->html->fechaTag('span');
                $buffer .= $this->html->abreTagAberta('span', array('style' => 'padding-left:8px;', 'class' => 'italico')) . 'Operador "OU QUE"' . $this->html->fechaTag('span');
            $buffer .= $this->html->fechaTag('a');
        $buffer .= $this->html->fechaTag('li');              

        $buffer .= $this->html->fechaTag('ul');
        $buffer .= $this->html->fechaTag('div');

        $buffer .= $this->html->abreTagAberta('input', array('id' => 'inputFoda', 'class' => 'form-control', 'placeholder' => 'Digite e torça!'));

        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('div');
        $buffer .= $this->html->fechaTag('form');

    }    
*/

}
