<?php

include_once '../../Config.php';

//define('GRUPO','Grupo');
//define('MODULO','Modulo');

define('DEFAULT_MODULO_NOME', 'Dashboard');
define('DEFAULT_MODULO_URL', 'dashboard');

echo (new \Sappiens\Grupo\Modulo\ModuloController($acao))->controle(\filter_input(INPUT_GET, 'acao'));