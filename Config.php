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

session_start();

header('Content-Type: text/html; charset=utf-8');

class Config
{

    public static $SIS_CFG;
    private static $SIS_INSTANCIA;

    private function __construct()
    {
        $this->setDiretorios();

        define('SIS_ID_NAMESPACE_PRJETO','Sappiens');
        define('SIS_NAMESPACE_PRJETO','C:/xampp/htdocs');
        
        self::$SIS_CFG = [
            'NomeCliente' => 'CENTER SIS',
            'TituloAdm' => 'ENGINE',
            'StringCrypt' => 'wzixjdy',
            'QLinhasGrid' => 17,
            'Bases'=>array('PADRAO'=>array(
                'Host'=>'192.168.25.51',
                'Banco'=>'onyxprev_sappiens',
                'Usuario'=>'onyxprev_sapp',
                'Senha'=>'qwertybracom'))];
    }

    /**
     * 	Padrão SINGLETON para Instanciar as Configuirações
     */
    public static function conf()
    {
        self::$SIS_INSTANCIA = new \Teste\Config();

        return self::$SIS_INSTANCIA;
    }

    private function setDiretorios()
    {
        define('SIS_DIR_BASE', str_replace('\\', '/', dirname(__FILE__)) . '/');
        define('SIS_URL_BASE', 'http://' . $_SERVER['SERVER_NAME'] . substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(SIS_DIR_BASE))));

        define('SIS_URL_BASE_STATIC','//static.sappiens.com.br');

        define('SIS_FM_BASE', 'C:/xampp/htdocs/Zion/');
        define('SIS_LAYOUT_BASE', 'http://localhost/Zion/Layout/');

        define('SIS_URL_FM_BASE', 'http://localhost/Zion/');

        define('SIS_DEFAULT_AUTOCOMPLETE',SIS_URL_BASE.'complete.php');
    }
}

\Teste\Config::conf();

require_once SIS_FM_BASE . 'Lib/Zion/ClassLoader/Loader.class.php';

(new \Zion\ClassLoader\Loader())
        ->setNamEspaces('Zion','C:/xampp/htdocs/Zion/Lib') //NameSpace do Framework
        ->setNamEspaces(SIS_ID_NAMESPACE_PRJETO,SIS_NAMESPACE_PRJETO) //NameSpace do Projeto
        ->setSufixos(array('', '.vo', '.class', '.interface')) //Sufixos em Geral
        ->inicio();
