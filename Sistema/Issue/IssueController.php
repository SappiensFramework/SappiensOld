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

namespace Sappiens\Sistema\Issue;

class IssueController extends \Zion\Core\Controller
{

    private $class;
    private $form;

    public function __construct()
    {
        $this->class = new \Sappiens\Sistema\Issue\IssueClass();
        $this->form = new \Sappiens\Sistema\Issue\IssueForm();
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

        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {

            switch (\filter_input(INPUT_POST, 'n')) {

                case 'inicial':
                    
                    $objForm = $this->form->getFormManu('alterar', $this->postCod());
                    $objForm->validar();
                    $this->class->alterar($objForm);

                break;           

                case 'interacao':

                    $objForm = $this->form->getFormManuInteracao('alterar', $this->postCod());
                    $objForm->validar();
                    $this->class->alterarInteracao($objForm);                   
                
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
                        $this->class->setValoresFormManuInteracao($cod, $this->form),
                        $this->class->setValoresFormManuHistorico($cod, $this->form));
            }
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);

    }

    protected function remover()
    {

        new \Zion\Acesso\Acesso('remover');

        $selecionados = $this->registrosSelecionados();
        $rSelecionados = \count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

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
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }
    
    protected function getIssueInteracoes()
    {

        $cod = \filter_input(INPUT_GET, 'a');
        $resultSet = $this->class->getIssueInteracoes($cod); 

        return parent::jsonSucesso($resultSet->fetch());

    }    

}
