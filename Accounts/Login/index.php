<?php

require '../../Config.php';

try {

	$html = new \Zion\Layout\Html();
	$formModulo = new \Sappiens\Grupo\Modulo\ModuloForm();
	$form = $formModulo->getFormModulo();

	$template = new \Pixel\Template\Template();

	$template->setConteudoHeader($html->abreTagAberta('link', array('href' => urlStatic . '/assets/stylesheets/login.css', 'rel' => 'stylesheet', 'type' => 'text/css')));
	$template->setConteudoBody('theme-default page-signin');
	$template->setConteudoContainerLogin($html->abreTagAberta('script', array('src' => urlStatic . '/assets/javascripts/login-prescripts.js')) . $html->fechaTag('script'));
	$template->setConteudoScripts($html->abreTagAberta('script', array('src' => urlStatic . '/assets/javascripts/login-postscripts.js')) . $html->fechaTag('script'));    
	$template->setConteudoFooter();    

} catch (Exception $ex) {
	exit($ex->getMessage());
}

define('DEFAULT_GRUPO_NOME', 'Accounts');
define('DEFAULT_MODULO_NOME', 'Login');
define('DEFAULT_MODULO_URL', 'Login');

echo $template->getTemplate('cabecalho');
echo $template->getTemplate('inicioCorpo');
echo $template->getTemplate('containerLogin');
echo $template->getTemplate('fimCorpo');
echo $template->getTemplate('rodape');

?>
