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

namespace Sappiens\GestaoAdministrativa\PessoaFisica;

class PessoaFisicaController extends \Zion\Core\Controller
{

    private $class;
    private $form;

    public function __construct()
    {
        $this->class = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaClass();
        $this->form = new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaForm();
    }

    protected function iniciar()
    {
        $retorno = '';

        try {

            new \Zion\Acesso\Acesso('filtrar');               
            $modulo = new \Sappiens\Sistema\Modulo\ModuloController();
            $template = new \Pixel\Template\Template();     
            $getBotoes = new \Pixel\Grid\GridBotoes();    
            $filtros = new \Pixel\Filtro\FiltroForm();            
                
            $mod = $modulo->getDadosModulo(MODULO);
            $template->setConteudoIconeModulo($mod['moduloclass']);
            $template->setConteudoNomeModulo($mod['modulodesc']);            
            $template->setConteudoScripts($this->form->getJSEstatico());
            
            $getBotoes->setFiltros($filtros->montaFiltro($this->form->getFormFiltro()));
            $botoes = $getBotoes->geraBotoes();
            $grid = $this->class->filtrar($this->form->getFormFiltro());
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

        return parent::jsonSucesso($this->class->filtrar($this->form->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->form->getFormManu('cadastrar');

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            $objForm->validar();
            $this->class->cadastrar($objForm);
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

        if ($this->metodoPOST()) {

            $codForm = $this->postCod();
            $cod = \filter_input(INPUT_POST, 'pessoaDocumentoTipoCod');

            switch (\filter_input(INPUT_POST, 'n')) {

                case 'inicial':
                    
                    $objForm = $this->form->getFormManu('alterar', $this->postCod());
                    $objForm->validar();
                    $this->class->alterar($objForm);

                break;

                case 'documento':

                    //print_r($_FILES);
                    $objFormHtml = $this->form->getFormManuDocumento('alterar', $this->postCod());
                    $objFormHtml->validar();                    

                    $param = $this->class->getCampos($cod);    
                    $objFormDinamico = $this->form->getObjetoCampos($param, $cod, $codForm);
                    //print_r($objFormDinamico);

                    $objFormDinamico->validar();
                    //$this->pessoaFisicaClass->alterarDocumento($objFormHtml); 

                    $resultCampos = $this->class->getCampos($cod);    
                    $objForm = $this->form->getObjetoCampos($resultCampos, $cod, $codForm);
                    $objForm->validar();

                    $this->class->alterarDocumento($objForm);                    
                
                break;
            
                case 'contato':
                    
                    $objForm = $this->form->getFormManuContato('alterar', $this->postCod());
                    $objForm->validar();
                    $this->class->alterarContato($objForm);

                break;            

            }

            $retorno = 'true';
            
        } else {

            $selecionados = $this->registrosSelecionados();            

            if (!\is_array($selecionados)) {
                throw new \Exception("Nenhum registro selecionado!");
            }

            $retorno = '';
            foreach ($selecionados as $cod) {
                
                $retorno = $this->emTabs($cod,
                        $this->class->setValoresFormManu($cod, $this->form),
                        $this->class->setValoresFormManuDocumento($cod, $this->form),
                        $this->class->setValoresFormManuContato($cod, $this->form));
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

                $this->class->remover($cod);

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

            $objForm = $this->class->setValoresFormManu($cod, $this->form);
            $retorno = $this->emTabs($cod,
                    $this->class->setValoresFormManu($cod, $this->form),
                    $this->class->setValoresFormManuDocumento($cod, $this->form),
                    $this->class->setValoresFormManuContato($cod, $this->form));
            //$retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }

    protected function getCamposDocumentos()
    {

        $form = '';
        $param = '';
        $cod = \filter_input(INPUT_GET, 'a');
        $codForm = \filter_input(INPUT_GET, 'd');

        $param = $this->class->getCampos($cod); 
        $form = $this->form->getFormCampos($param, $cod, $codForm);

        return parent::jsonSucesso($form);

    }

    protected function setValueSuggest()
    {
        //new \Zion\Acesso\Acesso('filtrar');

        $cod = \filter_input(INPUT_GET, 'a');
        return parent::jsonSucesso($cod);
        
    }     

}
