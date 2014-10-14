<?php
require '../../Config.php';
define('MODULO','Modulo');
try {

//	$html = new \Zion\Layout\Html();
//	$formModulo = new \Sappiens\Grupo\Modulo\ModuloForm();
//	$form = $formModulo->getFormModulo();
//
	$template = new \Pixel\Template\Template();

        $class = new Sappiens\Grupo\Modulo\ModuloClass();
    
	$template->setConteudoHeader();
	//$template->setConteudoMain(include('./ExemploForm.php'));
        //$template->setConteudoMain($form->montaForm());
        $template->setConteudoMain($class->grid());
        
	$template->setTooltipForm('Form1');
	$template->setConteudoFooter();    

} catch (Exception $ex) {
	exit($ex->getMessage());
}

define('DEFAULT_GRUPO_NOME', 'Grupo');
define('DEFAULT_MODULO_NOME', 'Módulo');
define('DEFAULT_MODULO_URL', 'Modulo');

echo $template->getTemplate();

