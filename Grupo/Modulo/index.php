<?php
require '../../Config.php';

try {

	$html = new \Zion\Layout\Html();
	$formModulo = new \Sappiens\Grupo\Modulo\ModuloForm();
	$form = $formModulo->getFormModulo();

	$template = new \Pixel\Template\Template();

	$template->setConteudoHeader();
	$template->setConteudoMain(include('./ExemploForm.php'));
    //$template->setConteudoMain($form->montaForm());
	$template->setTooltipForm('Form1');
	$template->setTooltipForm('grid-control');
	$template->setConteudoFooter();    

} catch (Exception $ex) {
	exit(\Zion\Exception\Exception::getMessageTrace($ex));
}

define('DEFAULT_GRUPO_NOME', 'Grupo');
define('DEFAULT_MODULO_NOME', 'Módulo');
define('DEFAULT_MODULO_URL', 'Modulo');

echo $template->getTemplate();

?>
