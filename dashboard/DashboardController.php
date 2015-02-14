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

namespace Sappiens\Dashboard;

class DashboardController extends \Zion\Core\Controller
{

    private $dashboardClass;
    private $dashboardForm;

    public function __construct()
    {
        //$this->dashboardClass = new \Sappiens\Dashboard\DashboardClass();
        //$this->dashboardForm = new \Sappiens\Dashboard\DashboardForm();
    }  

    protected function iniciar()
    {

        $retorno = '';

        try {

            $template = new \Pixel\Template\Template();
            $template->setConteudoIconeModulo('fa fa-dashboard');
            $template->setConteudoNomeModulo('Dashboard');
            $template->setTooltipForm('FormOrganograma');

            define('DEFAULT_MODULO_ICONE', 'fa fa-dashboard');
            define('DEFAULT_MODULO_NOME', 'Dashboard');
            define('DEFAULT_MODULO_URL', 'Dashboard');

        } catch (\Exception $ex) {
            
            $retorno = $ex;
        }

        $template->setConteudoMain($retorno);
        return $template->getTemplate();
        
    }

    protected function setOrganogramaCod()
    {
        //new \Zion\Acesso\Acesso('filtrar');

        $cod = \filter_input(INPUT_GET, 'a');
        $_SESSION['organogramaCod'] = $cod;
        return $_SESSION['organogramaCod'];       
    }    

    protected function resetOrganogramaCod()
    {
        //new \Zion\Acesso\Acesso('filtrar');

        $con = \Zion\Banco\Conexao::conectar();
        //$sql = new \Sappiens\Dashboard\DashboardSql();
        $sql = new \Pixel\Template\BarraSuperior\PesquisarOrganograma\PesquisarOrganogramaSql();
        $getDadosUsuario = $con->execLinhaArray($sql->getDadosUsuario($_SESSION['usuarioCod']));          
        $organogramaCodUsuario = $getDadosUsuario['organogramaCod'];        

        $_SESSION['organogramaCod'] = $organogramaCodUsuario;
        return $_SESSION['organogramaCod'];       
    } 

}
