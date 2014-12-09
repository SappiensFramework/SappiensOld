<?php

/**
 * @author Pablo Vanni - pablovanni@gmail.com
 * @since 16/05/2006
 * Autualizada Por: Pablo Vanni - pablovanni@gmail.com
 * @name Configurações para area administrativa
 * @version 2.0
 * @package Framework
 */
namespace Sappiens;

\header('Content-Type: text/html; charset=utf-8');

class Config
{

    public static $SIS_CFG;
    private static $SIS_INSTANCIA;

    private function __construct()
    {

        $this->setDiretorios();           

        define('SIS_ID_NAMESPACE_PROJETO','Sappiens');
        define('SIS_NAMESPACE_PROJETO','C:/xampp/htdocs');       
        define('SIS_SLOGAN', 'Simples. Flexível. Gostoso.');
        define('SIS_DESCRICAO', SIS_ID_NAMESPACE_PROJETO . ', Plataforma de Gestão Integrada para o Serviço Público');
        define('SIS_AUTOR', 'Pablo Vanni, Feliphe Bueno, Vinícius Pozzebon');
        define('SIS_RELEASE', 'Alpha');
        define('SIS_VENDOR_TEMPLATE','PixelAdmin');
        define('SIS_VENDOR_TEMPLATE_VERSION','1.3.0');   
        define('SIS_URL_BASE_TEMPLATE', SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/');     
        define('SIS_STRING_CRYPT', 'wzixjdy');
        define('SIS_LINHAS_GRID', '10');
        
        $_SESSION['usuarioCod'] = 1;//Usada temporariamente apenas para não busgar os componentes que dependem de UsuarioCod setado
        
        self::$SIS_CFG = [
            'bases'         => array('padrao'=> array(
                'host'      =>'192.168.25.51',
                'banco'     =>'onyxprev_sappiens',
                'usuario'   =>'onyxprev_sapp',
                'senha'     =>'qwertybracom'))];     

    }

    /**
     * 	Padrão SINGLETON para Instanciar as Configuirações
     */
    public static function conf()
    {

        self::$SIS_INSTANCIA = new \Sappiens\Config();
        return self::$SIS_INSTANCIA;

    }

    private function setDiretorios()
    {

        define('SIS_DIR_BASE', str_replace('\\', '/', dirname(__FILE__)) . '/');
        define('SIS_URL_BASE', '//' . $_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(SIS_DIR_BASE))));

        //define('SIS_URL_BASE_STATIC','//static.sappiens.com.br/');
        define('SIS_URL_BASE_STATIC','//192.168.25.51/~onyxprev/static/sappiens/');
        define('SIS_URL_BASE_DEFAULT','http://localhost'); // -> em ambiente online mudar para //app.sappiens.com.br

        define('SIS_FM_BASE', 'C:/xampp/htdocs/Zion/');
        define('SIS_LAYOUT_BASE', 'http://localhost/Zion/Layout/');

        define('SIS_URL_FM_BASE', 'http://localhost/Zion/');

        define('SIS_DEFAULT_AUTOCOMPLETE', SIS_URL_BASE . 'includes/autocomplete/');

    }
}

\Sappiens\Config::conf();

require_once SIS_FM_BASE . 'Lib/Zion/ClassLoader/Loader.php';

(new \Zion\ClassLoader\Loader())
        ->setNamEspaces('Zion', 'C:/xampp/htdocs/Zion/Lib') //NameSpace do Framework
        ->setNamEspaces('Pixel', 'C:/xampp/htdocs/Zion/Lib') //NameSpace do Template
        ->setNamEspaces(SIS_ID_NAMESPACE_PROJETO, SIS_NAMESPACE_PROJETO) //NameSpace do Projeto
        ->inicio();