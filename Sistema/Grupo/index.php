<?php

require '../../Config.php';

define('GRUPO', 'Sistema');
define('MODULO', 'Grupo');
define('DEFAULT_MODULO_NOME', 'Gerenciar Grupos');
define('DEFAULT_MODULO_URL', 'Grupo');

echo (new \Sappiens\Sistema\Grupo\GrupoController())->controle(\filter_input(\INPUT_GET, 'acao'));
