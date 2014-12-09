<?php

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
