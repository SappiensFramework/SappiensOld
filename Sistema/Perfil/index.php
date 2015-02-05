<?php

require '../../Config.php';

\define('MODULO', 'Perfil');

echo (new \Sappiens\Sistema\Perfil\PerfilController())->controle(\filter_input(\INPUT_GET, 'acao'));
