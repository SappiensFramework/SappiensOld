<?php

require '../Config.php';

try {

	$html     = new \Zion\Layout\Html();
	$template = new \Pixel\Template\Template();

    $tabArray = array(
        array('tabId' => 1,
              'tabActive' => 'active',
              'tabTitle' => 'Titulo da tab 1', 
              'tabContent' => '<button class="btn btn-success" data-toggle="modal" data-target="#modalmsg">Success</button>'
              ),
        array('tabId' => 2,
              'tabActive' => '',
              'tabTitle' => 'Titulo da tab 2', 
              'tabContent' => 'Conteudo da tab 2'
              ),
        array('tabId' => 3,
              'tabActive' => '',
              'tabTitle' => 'Titulo da tab 3', 
              'tabContent' => 'Conteudo da tab 3'
              ),
        array('tabId' => 4,
              'tabActive' => '',
              'tabTitle' => 'Titulo da tab 4', 
              'tabContent' => 'Conteudo da tab 4'
              ),
        array('tabId' => 5,
              'tabActive' => '',
              'tabTitle' => 'Titulo da tab 5', 
              'tabContent' => 'Conteudo da tab 5'
              )                    
        );

    $tab = $template->getTab('tabWelcome', array('classCss' => 'col-sm-6'), $tabArray);
    $panel = $template->getPanel('box-welcome', 'Bem-vindo', $tab, ['titleVisible' => true, 'startVisible' => true, 'iconTitle' => 'fa fa-filter']);

	$template->setConteudoHeader();
	$template->setConteudoMain($panel);
	$template->setConteudoScripts();
	$template->setConteudoFooter();


} catch (Exception $ex) {
    exit($ex->getMessage());
}

// Define o nome do módulo e o nome amigável ao usuário
define('DEFAULT_MODULO_ICONE', 'fa fa-dashboard');
define('DEFAULT_MODULO_NOME', 'Dashboard');
define('DEFAULT_MODULO_URL', 'Dashboard');

echo $template->getTemplate();

?>