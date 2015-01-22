<?php

require '../../Config.php';

define('GRUPO', 'Grupo');
define('MODULO', 'Conteudo');
define('DEFAULT_MODULO_NOME', 'Conteúdo');
define('DEFAULT_MODULO_URL', 'Conteudo');

echo (new Sappiens\GestaoAdministrativa\Conteudo\ConteudoController())->controle(\filter_input(\INPUT_GET, 'acao'));
