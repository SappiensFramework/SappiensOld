<?php
require '../../Config.php';

define('MODULO', 'Modulo');
define('DEFAULT_MODULO_NOME', 'Dashboard');
define('DEFAULT_MODULO_URL', 'dashboard');

echo (new \Sappiens\Grupo\Modulo\ModuloController($acao))->controle(\filter_input(INPUT_GET, 'acao'));
