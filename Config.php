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

/**
 * @author Pablo Vanni - pablovanni@gmail.com
 * @since 16/05/2006
 * Atualizada Por: Pablo Vanni - pablovanni@gmail.com
 * @name Configurações para area administrativa
 * @version 2.0
 * @package Framework
 */
namespace Sappiens;

class Config
{

    public static $SIS_CFG;
    private static $SIS_INSTANCIA;

    private function __construct()
    {
        
        \session_start();

        \header('Content-Type: text/html; charset=utf-8');

        $this->setDiretorios('dev');           

        define('SIS_SLOGAN', 'Simples. Flexível. Poderoso.');
        define('SIS_DESCRICAO', SIS_ID_NAMESPACE_PROJETO . ', Plataforma de Gestão Integrada');
        define('SIS_AUTOR', 'The Sappiens Team');
        define('SIS_RELEASE', 'Alpha');
        define('SIS_VENDOR_TEMPLATE','PixelAdmin');
        define('SIS_VENDOR_TEMPLATE_VERSION','1.3.0');   
        define('SIS_URL_BASE_TEMPLATE', SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/');     
        define('SIS_STRING_CRYPT', 'wzixjdy');
        define('SIS_LINHAS_GRID', '10');

    }

    /**
     * 	Padrão SINGLETON para Instanciar as Configuirações
     */
    public static function conf()
    {

        self::$SIS_INSTANCIA = new \Sappiens\Config();
        return self::$SIS_INSTANCIA;

    }

    private function setDiretorios($modo = 'prod')
    {

        define('SIS_DIR_BASE', str_replace('\\', '/', dirname(__FILE__)) . '/');
        define('SIS_URL_BASE', '//' . $_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(SIS_DIR_BASE))));

        if($modo == 'dev') {

            define('SIS_URL_BASE_STATIC', SIS_URL_BASE . 'Static/');
            define('SIS_URL_BASE_DEFAULT','http://localhost');
            define('SIS_FM_BASE', 'C:/xampp/htdocs/Zion/');
            define('SIS_LAYOUT_BASE', 'http://localhost/Zion/Layout/');
            define('SIS_URL_FM_BASE', 'http://localhost/Zion/Static/');
            define('SIS_DEFAULT_AUTOCOMPLETE', SIS_URL_BASE . 'includes/autocomplete/');

            define('SIS_ID_NAMESPACE_PROJETO','Sappiens');
            define('SIS_NAMESPACE_PROJETO','C:/xampp/htdocs');  
            define('SIS_NAMESPACE_FRAMEWORK', 'C:/xampp/htdocs/Zion/Lib');
            define('SIS_NAMESPACE_TEMPLATE', 'C:/xampp/htdocs/Zion/Lib');

            self::$SIS_CFG = [
                'bases'         => array('padrao' => array(
                    'driver'    =>'pdo_mysql',
                    'host'      =>'192.168.25.51',
                    'banco'     =>'onyxprev_sappiens',
                    'usuario'   =>'onyxprev_sapp',
                    'senha'     =>'qwertybracom'))];             

        } elseif($modo == 'alpha') {

            define('SIS_URL_BASE_STATIC', SIS_URL_BASE . 'Static/');
            define('SIS_URL_BASE_DEFAULT','//team.sappiens.com.br/alpha');
            define('SIS_FM_BASE', '/home/sappienscom/public_html/alpha/Zion/');
            define('SIS_LAYOUT_BASE', 'http://team.sappiens.com.br/alpha/Zion/Layout/');
            define('SIS_URL_FM_BASE', 'http://team.sappiens.com.br/alpha/Zion/Static/');
            define('SIS_DEFAULT_AUTOCOMPLETE', SIS_URL_BASE . 'includes/autocomplete/');

            define('SIS_ID_NAMESPACE_PROJETO','Sappiens');
            define('SIS_NAMESPACE_PROJETO','/home/sappienscom/public_html/alpha');    
            define('SIS_NAMESPACE_FRAMEWORK', '/home/sappienscom/public_html/alpha/Zion/Lib');
            define('SIS_NAMESPACE_TEMPLATE', '/home/sappienscom/public_html/alpha/Zion/Lib');

            self::$SIS_CFG = [
                'bases'         => array('padrao' => array(
                    'driver'    =>'pdo_mysql',
                    'host'      =>'localhost',
                    'banco'     =>'onyxprev_sappiens',
                    'usuario'   =>'onyxprev_sapp',
                    'senha'     =>'qwertybracom'))]; 

        } elseif($modo == 'prod') {

            define('SIS_URL_BASE_STATIC','//static.sappiens.com.br/');
            define('SIS_URL_BASE_DEFAULT','//app.sappiens.com.br');
            define('SIS_FM_BASE', '/home/sappiens/public_html/app/Zion/');
            define('SIS_LAYOUT_BASE', 'http://app.sappiens.com.br/Zion/Layout/');
            define('SIS_URL_FM_BASE', 'http://app.sappiens.com.br/Zion/');
            define('SIS_DEFAULT_AUTOCOMPLETE', SIS_URL_BASE . 'includes/autocomplete/');

            define('SIS_NAMESPACE_FRAMEWORK', '/home/sappiens/public_html/app/Zion/Lib');
            define('SIS_NAMESPACE_TEMPLATE', '/home/sappiens/public_html/app/Zion/Lib');

            self::$SIS_CFG = [
                'bases'         => array('padrao' => array(
                    'host'      =>'localhost',
                    'banco'     =>'onyxprev_sappiens',
                    'usuario'   =>'onyxprev_sapp',
                    'senha'     =>'qwertybracom'))];            

        }

    }
}


\Sappiens\Config::conf();

$modulo = \defined('MODULO') ? MODULO : '';

if($modulo != 'Login') {
    if(!$_SESSION['usuarioCod'] or !$_SESSION['organogramaCod']) {
        header('location: ' . SIS_URL_BASE . 'Accounts/Login?err=Acesse a sua conta para continuar!');
    } 
}

function sisErro($errno, $errstr, $errfile, $errline)
{
    throw new \Exception("'<pre>'Erro: " . $errno . ' - ' . $errstr . ' - ' . $errfile . ' - ' . $errline.'</pre>');
}

\set_error_handler("\\Sappiens\\sisErro", \E_WARNING | \E_NOTICE);

require_once SIS_FM_BASE . 'Lib/Zion/ClassLoader/Loader.php';

(new \Zion\ClassLoader\Loader())
        ->setNameSpaces('Zion', SIS_NAMESPACE_FRAMEWORK) //NameSpace do Framework
        ->setNameSpaces('Pixel', SIS_NAMESPACE_TEMPLATE) //NameSpace do Template
        ->setNameSpaces(SIS_ID_NAMESPACE_PROJETO, SIS_NAMESPACE_PROJETO) //NameSpace do Projeto
        ->inicio();