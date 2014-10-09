<?php
require '../../Config.php';

try {

	$html = new \Zion\Layout\Html();
	$formModulo = new \Sappiens\Grupo\Modulo\ModuloForm();
	$form = $formModulo->getFormModulo();

	$template = new \Pixel\Template\Template();

	$template->setConteudoHeader();
	$template->setConteudoMain(include('./ExemploForm.php'));
	$template->setTooltipForm('Form1');
	//$template->setConteudoScripts('<script src="' . SIS_URL_BASE_STATIC . SIS_VENDOR_TEMPLATE . '/' . SIS_VENDOR_TEMPLATE_VERSION . '/assets/javascripts/jquery-ui-extras.min.js"></script>');
	//$template->setConteudoScripts('<script>var initTooltipsDemo=function(){if(window.JQUERY_UI_EXTRAS_LOADED){$(\'#Form1\').tooltip()}};init.push(initTooltipsDemo);</script>');	
	//$template->
	$template->setConteudoFooter();    

} catch (Exception $ex) {
	exit($ex->getMessage());
}

define('DEFAULT_GRUPO_NOME', 'Grupo');
define('DEFAULT_MODULO_NOME', 'Módulo');
define('DEFAULT_MODULO_URL', 'Modulo');

echo $template->getTemplate();

?>
