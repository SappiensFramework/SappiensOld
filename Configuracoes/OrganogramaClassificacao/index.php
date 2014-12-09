<?php

require '../../Config.php';

if(!$_SESSION['usuarioCod'] or !$_SESSION['organogramaCod']) {
  header('location: ../../?err=Sessão expirada!');
}

define('GRUPO', 'Configuracoes');
define('MODULO', 'OrganogramaClassificacao');
define('DEFAULT_GRUPO_NOME', 'Configuracoes');
define('DEFAULT_MODULO_NOME', 'Classificação');
define('DEFAULT_MODULO_URL', 'OrganogramaClassificacao');

echo (new \Sappiens\Configuracoes\OrganogramaClassificacao\OrganogramaClassificacaoController())->controle(\filter_input(\INPUT_GET, 'acao'));
