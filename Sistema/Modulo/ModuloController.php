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

namespace Sappiens\Sistema\Modulo;

class ModuloController extends \Zion\Core\Controller
{

    private $moduloClass;
    private $moduloForm;

    public function __construct()
    {
        $this->moduloClass = new \Sappiens\Sistema\Modulo\ModuloClass();
        $this->moduloForm = new \Sappiens\Sistema\Modulo\ModuloForm();
    }

    protected function iniciar()
    {
        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();            
            $mod = $this->moduloClass->getDadosModulo(MODULO);
            $template->setConteudoIconeModulo($mod['moduloclass']);
            $template->setConteudoNomeModulo($mod['modulodesc']);              

            new \Zion\Acesso\Acesso('filtrar');
            
            $template->setConteudoScripts($this->moduloForm->getJSEstatico());

            $iBotoes = new \Pixel\Grid\GridBotoes();

            $filtros = new \Pixel\Filtro\FiltroForm();

            $iBotoes->setFiltros($filtros->montaFiltro($this->moduloForm->getFormFiltro()));
            $botoes = $iBotoes->geraBotoes();

            $grid = $this->moduloClass->filtrar($this->moduloForm->getFormFiltro());

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

        return parent::jsonSucesso($this->moduloClass->filtrar($this->moduloForm->getFormFiltro()));
    }

    protected function cadastrar()
    {
        new \Zion\Acesso\Acesso('cadastrar');

        $objForm = $this->moduloForm->getFormManu('cadastrar');

        if ($this->metodoPOST()) {

            $objForm->validar();

            $this->moduloClass->cadastrar($objForm);

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

            $objForm = $this->moduloForm->getFormManu('alterar', $this->postCod());

            $objForm->validar();

            $this->moduloClass->alterar($objForm);

            $retorno = 'true';
        } else {
            
            $selecionados = $this->registrosSelecionados();            

            $retorno = '';
            foreach ($selecionados as $cod) {

                $objForm = $this->moduloClass->setValoresFormManu($cod, $this->moduloForm);
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

        $selecionados = $this->registrosSelecionados();        
        $rSelecionados = \count($selecionados);
        $rApagados = 0;
        $mensagem = [];

        try {

            foreach ($selecionados as $cod) {

                $this->moduloClass->remover($cod);

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
        
        $selecionados = $this->registrosSelecionados();

        $retorno = '';
        foreach ($selecionados as $cod) {

            $objForm = $this->moduloClass->setValoresFormManu($cod, $this->moduloForm);
            $retorno .= $objForm->montaFormVisualizar();
        }

        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $retorno]);
    }
    
    protected function mudaPosicao()
    {
        new \Zion\Acesso\Acesso('alterar');
        
        $posicao = $this->moduloClass->mudaPosicao(\filter_input(\INPUT_GET, 'moduloCod'), \filter_input(\INPUT_GET, 'maisMenos'));
        
        return \json_encode([
            'sucesso' => 'true',
            'retorno' => $posicao]);
    }
    
    public function getDadosModulo($modulo)
    {
        
        return $this->moduloClass->getDadosModulo($modulo);

    }
    
}
