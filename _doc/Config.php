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

/**
 * 
 * @since 16/05/2006
 * @author Pablo Vanni <pablovanni@gmail.com>
 * @author Vinicius Pozzebon <vpozzebon@gmail.com>
 * @author Feliphe Bueno <feliphezion@gmail.com>
 * 
 * @name Configurações para area administrativa
 * @version 2.0
 * @package Framework
 * 
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

        /**
         * 
         * ATENÇÃO!!! ATTENTION!!! AVISO!!!
         * Personalização necessária nos métodos abaixo:
         * @setCommon();
         * @setDatabase();
         * @author Vinicius Pozzebon <vpozzebon@gmail.com>
         * 
         */        
        $this->setCommon();
        $this->setDatabase();

        \define('SIS_SLOGAN', 'Simples. Flexível. Poderoso.');
        \define('SIS_DESCRICAO', \SIS_ID_NAMESPACE_PROJETO . ' Framework');
        \define('SIS_AUTOR', 'The Sappiens Team');
        \define('SIS_VENDOR_TEMPLATE','PixelAdmin');
        \define('SIS_VENDOR_TEMPLATE_VERSION','1.3.0');   
        \define('SIS_URL_BASE_TEMPLATE', \SIS_VENDOR_TEMPLATE . '/' . \SIS_VENDOR_TEMPLATE_VERSION . '/');     
        \define('SIS_STRING_CRYPT', '91278404eafff215ba0e9a400d652475');
        \define('SIS_LINHAS_GRID', '10');

    }

    /**
     * 
     * SINGLETON para instanciar as configurações
     * @author Pablo Vanni <pablovanni@gmail.com>
     * 
     */
    public static function conf()
    {

        self::$SIS_INSTANCIA = new \Sappiens\Config();
        return self::$SIS_INSTANCIA;

    }
    
    /**
     * 
     * ATENÇÃO!!! ATTENTION!!! AVISO!!!
     * Personalização necessária no método abaixo!
     * Oracle, MSSQLServer, PostgreSQL ainda não homologados!
     * Abstração via Doctrine/DBAL
     * @author Vinicius Pozzebon <vpozzebon@gmail.com>
     * 
     */         
    private function setDatabase($vendor = 'padrao')
    {
        
        self::$SIS_CFG = [

            'bases' => [
                
                /*
                 * Vendor MySQL
                 */
                'padrao' => [

                    'host'      => '192.168.25.51',
                    'banco'     => 'sappiens',
                    'usuario'   => 'sapp',
                    'senha'     => '***',
                    'driver'    => 'pdo_mysql'
                    
                ],                

                /*
                 * Vendor PostgreSQL
                 */
                'padraoW' => [

                    'host'      => 's2.virtuaserver.com.br',
                    'banco'     => 'sappiens_dev',
                    'usuario'   => 'sappiens_user',
                    'senha'     => '***',
                    'driver'    => 'pdo_pgsql'
                    
                ],

                /*
                 * Vendor Oracle
                 */
                'padraoX' => [

                    'driver'    => 'pdo_mysql',
                    'host'      => '192.168.25.51',
                    'banco'     => 'SAPPIENS_DEV',
                    'usuario'   => 'SAPPIENS',
                    'senha'     => '***',
                    'driver'    => 'pdo_ocisql'
                    
                ],

                /*
                 * Vendor MS SQLServer
                 */
                'padraoy' => [

                    'host'      => 'DEV1\SQLEXPRESS',
                    'banco'     => 'engine',
                    'usuario'   => 'SAPP',
                    'senha'     => '***',
                    'driver'    => 'pdo_sqlsrv'
                    
                ]
            ]
        ];        
        
    }

    /**
     * 
     * ATENÇÃO!!! ATTENTION!!! AVISO!!!
     * Personalização necessária no método abaixo!
     * @author Vinicius Pozzebon <vpozzebon@gmail.com>
     * 
     */     
    private function setCommon($version = 'dev')
    {

        \define('SIS_DIR_BASE', \str_replace('\\', '/', \dirname(__FILE__)) . '/');
        \define('SIS_URL_BASE', '//' . $_SERVER['SERVER_NAME'] . \substr($_SERVER['PHP_SELF'], 0, - (\strlen($_SERVER['SCRIPT_FILENAME']) - \strlen(\SIS_DIR_BASE))));

        if($version == 'dev') {

            \define('SIS_URL_BASE_STATIC', \SIS_URL_BASE . 'Static/');
            \define('SIS_URL_BASE_DEFAULT','http://localhost');
            \define('SIS_FM_BASE', 'C:/xampp/htdocs/Zion/');
            \define('SIS_LAYOUT_BASE', 'http://localhost/Zion/Layout/');
            \define('SIS_URL_FM_BASE', 'http://localhost/Zion/Static/');
            \define('SIS_DEFAULT_AUTOCOMPLETE', \SIS_URL_BASE . 'includes/autocomplete/');
            \define('SIS_DEFAULT_DEPENDENCIA', \SIS_URL_BASE . 'includes/dependencia/');

            \define('SIS_ID_NAMESPACE_PROJETO','Sappiens');
            \define('SIS_NAMESPACE_PROJETO','C:/xampp/htdocs');  
            \define('SIS_NAMESPACE_FRAMEWORK', 'C:/xampp/htdocs/Zion/Lib');
            \define('SIS_NAMESPACE_TEMPLATE', 'C:/xampp/htdocs/Zion/Lib');
            \define('SIS_RELEASE', 'Developer');

        } elseif($version == 'alpha') {

            \define('SIS_URL_BASE_STATIC', \SIS_URL_BASE . 'Static/');
            \define('SIS_URL_BASE_DEFAULT','//team.sappiens.com.br/alpha');
            \define('SIS_FM_BASE', '/home/sappienscom/public_html/alpha/Zion/');
            \define('SIS_LAYOUT_BASE', 'http://team.sappiens.com.br/alpha/Zion/Layout/');
            \define('SIS_URL_FM_BASE', 'http://team.sappiens.com.br/alpha/Zion/Static/');
            \define('SIS_DEFAULT_AUTOCOMPLETE', \SIS_URL_BASE . 'includes/autocomplete/');
            \define('SIS_DEFAULT_DEPENDENCIA', \SIS_URL_BASE . 'includes/dependencia/');

            \define('SIS_ID_NAMESPACE_PROJETO','Sappiens');
            \define('SIS_NAMESPACE_PROJETO','/home/sappienscom/public_html/alpha');    
            \define('SIS_NAMESPACE_FRAMEWORK', '/home/sappienscom/public_html/alpha/Zion/Lib');
            \define('SIS_NAMESPACE_TEMPLATE', '/home/sappienscom/public_html/alpha/Zion/Lib');
            \define('SIS_RELEASE', 'Alpha');

        } elseif($version == 'prod') {

            \define('SIS_URL_BASE_STATIC','//static.sappiens.com.br/');
            \define('SIS_URL_BASE_DEFAULT','//app.sappiens.com.br');
            \define('SIS_FM_BASE', '/home/sappiens/public_html/app/Zion/');
            \define('SIS_LAYOUT_BASE', 'http://app.sappiens.com.br/Zion/Layout/');
            \define('SIS_URL_FM_BASE', 'http://app.sappiens.com.br/Zion/');
            \define('SIS_DEFAULT_AUTOCOMPLETE', \SIS_URL_BASE . 'includes/autocomplete/');
            \define('SIS_DEFAULT_DEPENDENCIA', \SIS_URL_BASE . 'includes/dependencia/');

            \define('SIS_NAMESPACE_FRAMEWORK', '/home/sappiens/public_html/app/Zion/Lib');
            \define('SIS_NAMESPACE_TEMPLATE', '/home/sappiens/public_html/app/Zion/Lib');
            \define('SIS_RELEASE', 'Production');           

        }

    }
    
}

\Sappiens\Config::conf();

$modulo = \defined('MODULO') ? MODULO : '';

if($modulo != 'Login') {
    if(!$_SESSION['usuarioCod'] or !$_SESSION['organogramaCod']) {
        header('location: ' . \SIS_URL_BASE . 'Accounts/Login?err=Acesse a sua conta para continuar!');
    }
}

function sisErro($errno, $errstr, $errfile, $errline)
{
    throw new \Exception("Erro: " . $errno . ' - ' . $errstr . ' - ' . $errfile . ' - ' . $errline);
}

function sisException($e)
{
    exit("Uncaught Exception: <br />\n <pre>". \Zion\Exception\Exception::getMessageTrace($e) ."</pre>");
}

\set_error_handler("\\Sappiens\\sisErro", \E_WARNING | \E_NOTICE);
\set_exception_handler("\\Sappiens\\sisException");

require_once \SIS_FM_BASE . 'Lib/Zion/ClassLoader/Loader.php';

(new \Zion\ClassLoader\Loader())
        ->setNameSpaces('Zion', \SIS_NAMESPACE_FRAMEWORK) //NameSpace do Framework
        ->setNameSpaces('Pixel', \SIS_NAMESPACE_TEMPLATE) //NameSpace do Template
        ->setNameSpaces(\SIS_ID_NAMESPACE_PROJETO, \SIS_NAMESPACE_PROJETO) //NameSpace do Projeto
        ->inicio();
