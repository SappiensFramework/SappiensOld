<?php

require '../Config.php';
$html   = new \Zion\Layout\Html();

try {

	$template = new \Sappiens\includes\Template();

	$template->setConteudoHeader();
	$template->setConteudoMain('Conteúdo do Dashboard');
	$template->setConteudoScripts();
	$template->setConteudoFooter();


} catch (Exception $ex) {
    exit($ex->getMessage());
}

// Define o nome do módulo e o nome amigável ao usuário
define('DEFAULT_MODULO_NOME', 'Dashboard');
define('DEFAULT_MODULO_URL', 'Dashboard');

echo $template->getTemplate();

?>