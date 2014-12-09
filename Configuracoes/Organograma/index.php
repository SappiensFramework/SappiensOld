<?php

require '../../Config.php';

if(!$_SESSION['usuarioCod'] or !$_SESSION['organogramaCod']) {
  header('location: ../../?err=Sessão expirada!');
}

define('GRUPO', 'Configuracoes');
define('MODULO', 'Organograma');
define('DEFAULT_GRUPO_NOME', 'Configuracoes');
define('DEFAULT_MODULO_NOME', 'Organograma');
define('DEFAULT_MODULO_URL', 'Organograma');

echo (new \Sappiens\Configuracoes\Organograma\OrganogramaController())->controle(\filter_input(\INPUT_GET, 'acao'));
