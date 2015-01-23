<?php

require '../../Config.php';

define('GRUPO', 'Grupo');
define('MODULO', 'Modulo');
define('DEFAULT_MODULO_NOME', 'Domínio');
define('DEFAULT_MODULO_URL', 'Dominio');

echo (new Sappiens\GestaoAdministrativa\Dominio\DominioController())->controle(\filter_input(\INPUT_GET, 'acao'));
