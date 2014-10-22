<?php
require '../../Config.php';

define('MODULO', 'Modulo');
define('DEFAULT_GRUPO_ICONE', 'fa fa-university');
define('DEFAULT_GRUPO_NOME', 'Gestão Administrativa');
define('DEFAULT_GRUPO_URL', 'Grupo');
define('DEFAULT_MODULO_ICONE', 'fa fa-user');
define('DEFAULT_MODULO_NOME', 'Pessoa física');
define('DEFAULT_MODULO_URL', 'PessoaFisica');

echo (new \Sappiens\Grupo\Modulo\ModuloController($acao))->controle(\filter_input(INPUT_GET, 'acao'));
