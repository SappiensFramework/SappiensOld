<?php

require '../../Config.php';

try {

	$html = new \Zion\Layout\Html();
	$formModulo = new \Sappiens\Grupo\Modulo\ModuloForm();
	$form = $formModulo->getFormModulo();

	$template = new \Pixel\Template\Template();

	$template->setConteudoHeader();
	$template->setConteudoBody('theme-default page-signin');
	$template->setConteudoMain('');
	//$template->setTooltipForm('Form1');
	$template->setConteudoFooter();    

} catch (Exception $ex) {
	exit($ex->getMessage());
}

define('DEFAULT_GRUPO_NOME', 'Accounts');
define('DEFAULT_MODULO_NOME', 'Login');
define('DEFAULT_MODULO_URL', 'Login');

echo $template->getTemplate('cabecalho');
echo $template->getTemplate('inicioCorpo');
echo $template->getTemplate('fimCorpo');
echo $template->getTemplate('rodape');

?>
