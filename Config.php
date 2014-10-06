<?php

/**
 * @author Pablo Vanni - pablovanni@gmail.com
 * @since 16/05/2006
 * Autualizada Por: Pablo Vanni - pablovanni@gmail.com
 * @name Configurações para area administrativa
 * @version 2.0
 * @package Framework
 */

header('Content-Type: text/html; charset=utf-8');

class Config
{

    public static $CFG;
    private static $Instancia;

    private function __construct()
    {
        $this->setDiretorios();

        define('CFG_SIS_NOME', 'Sappiens');
        define('CFG_SIS_DESCRICAO', CFG_SIS_NOME . ', Plataforma de Gestão Integrada para o Serviço Público');
        define('CFG_SIS_AUTOR', 'Pablo Vanni, Feliphe Bueno, Vinícius Pozzebon');
        define('CFG_SIS_RELEASE', 'Alpha');
        define('CFG_SIS_STRING_CRYPT', 'wzixjdy');
        define('CFG_SIS_LINHAS_GRID', '30');
        define('CFG_NAMESPACE', 'projeto');
        define('CFG_VENDOR_TEMPLATE','PixelAdmin');
        define('CFG_VENDOR_TEMPLATE_VERSION','1.3.0');

        self::$CFG = [
            "NomeCliente" => "CENTER SIS",
            "TituloAdm" => "ENGINE",
            "StringCrypt" => "wzixjdy",
            "QLinhasGrid" => 17];
    }

    /**
     * 	Padrão SINGLETON para Instanciar as Configuirações
     */
    public static function Conf()
    {
        self::$Instancia = new Config();

        return self::$Instancia;
    }

    private function setDiretorios()
    {
        if (!isset($_SESSION['Config'])) {
            $_SESSION['Config'] = true;

            define('DIR_BASE', str_replace('\\', '/', dirname(__FILE__)) . '/');
            define('URL_BASE', 'http://' . $_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(DIR_BASE))));

            define('URL_BASE_DEFAULT','http://localhost'); // -> em ambiente online mudar para //app.sappiens.com.br
            define('DIR_BASE_DEFAULT','C:/xampp/htdocs/Sappiens/');
            define('URL_BASE_STATIC','//static.sappiens.com.br/');
            
            define('FM_BASE', 'C:/xampp/htdocs/Zion/');
            define('LAYOUT_BASE', 'http://localhost/Zion/Layout/');

            define('URL_FM_BASE', 'http://localhost/Zion/');
        }
    }

}

Config::Conf();

require_once FM_BASE . 'Lib/Zion/ClassLoader/Loader.class.php';

(new Zion\ClassLoader\Loader())
        ->setNamEspaces('Zion','C:/xampp/htdocs/Zion/Lib') //NameSpace do Framework
        ->setNamEspaces('Sappiens','C:/xampp/htdocs') //NameSpace do Projeto
        ->setSufixos(array('', '.vo', '.class', '.interface')) //Sufixos em Geral
        ->inicio();