<?php

require '../../Config.php';

define('GRUPO', 'GestaoAdministrativa');
define('MODULO', 'PessoaFisica');
define('DEFAULT_GRUPO_NOME', 'Gestão Administrativa');
define('DEFAULT_MODULO_NOME', 'Pessoa Física');
define('DEFAULT_MODULO_URL', 'PessoaFisica');

echo (new \Sappiens\GestaoAdministrativa\PessoaFisica\PessoaFisicaController())->controle(\filter_input(\INPUT_GET, 'acao'));
