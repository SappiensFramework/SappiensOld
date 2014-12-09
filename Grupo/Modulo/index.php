<?php

require '../../Config.php';

if(!$_SESSION['usuarioCod'] or !$_SESSION['organogramaCod']) {
  header('location: ../../?err=Sessão expirada!');
}

define('GRUPO', 'Grupo');
define('MODULO', 'Modulo');
define('DEFAULT_MODULO_NOME', 'Módulo');
define('DEFAULT_MODULO_URL', 'Modulo');

echo (new \Sappiens\Grupo\Modulo\ModuloController())->controle(\filter_input(\INPUT_GET, 'acao'));
