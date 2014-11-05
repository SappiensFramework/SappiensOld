<?php

require '../../Config.php';

define('GRUPO', 'Grupo');
define('MODULO', 'Modulo');
define('DEFAULT_MODULO_NOME', 'Módulo');
define('DEFAULT_MODULO_URL', 'Modulo');

echo (new \Sappiens\Grupo\Modulo\ModuloControllerB())->controle(\filter_input(\INPUT_GET, 'acao'));
