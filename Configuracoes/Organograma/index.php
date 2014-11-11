<?php

require '../../Config.php';

define('GRUPO', 'Configuracoes');
define('MODULO', 'Organograma');
define('DEFAULT_MODULO_NOME', 'Organograma');
define('DEFAULT_MODULO_URL', 'Organograma');

echo (new \Sappiens\Configuracoes\Organograma\OrganogramaController())->controle(\filter_input(\INPUT_GET, 'acao'));
