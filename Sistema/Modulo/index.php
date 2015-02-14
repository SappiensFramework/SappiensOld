<?php

require '../../Config.php';
require 'ModuloController.php';
\define('GRUPO', 'Sistema');
\define('MODULO', 'Modulo');
\define('DEFAULT_MODULO_NOME', 'Gerenciar Modulos');
\define('DEFAULT_MODULO_URL', 'Modulo');

echo (new \Sappiens\Sistema\Modulo\ModuloController())->controle(\filter_input(\INPUT_GET, 'acao'));
