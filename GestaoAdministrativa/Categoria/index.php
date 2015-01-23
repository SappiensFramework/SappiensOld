<?php

require '../../Config.php';

define('GRUPO', 'Grupo');
define('MODULO', 'Modulo');
define('DEFAULT_MODULO_NOME', 'Categoria');
define('DEFAULT_MODULO_URL', 'Categoria');

echo (new Sappiens\GestaoAdministrativa\Categoria\CategoriaController())->controle(\filter_input(\INPUT_GET, 'acao'));
