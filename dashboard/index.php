<?php

require '../Config.php';
$padrao = new \Zion\Layout\Padrao();
$html   = new \Zion\Layout\Html();

try {

	$template = new \Sappiens\includes\Template();


} catch (Exception $ex) {
    exit($ex->getMessage());
}

// Define o nome do módulo e o nome amigável ao usuário
define('DEFAULT_MODULO_NOME', 'Dashboard');

echo $padrao->topo();
echo $template->getCabecalho();

echo $html->abreTagAberta('body', array('class' => 'theme-asphalt main-menu-animated'));
echo $html->abreTagAberta('div', array('id' => 'main-wrapper'));

echo $template->getBarraSuperior();	
echo $template->getMenuLateral();

// start: content-wrapper
echo $html->abreTagAberta('div', array('id' => 'content-wrapper'));
// end: content-wrapper
echo $html->fechaTag('div');

// start: main-menu-bg
echo $html->abreTagAberta('div', array('id' => 'main-menu-bg'));
// end: main-menu-bg
echo $html->fechaTag('div');

// end: main-navbar
echo $html->fechaTag('div');
// end: main-wrapper
echo $html->fechaTag('div');

echo $template->getRodape();
echo $padrao->rodape();

?>