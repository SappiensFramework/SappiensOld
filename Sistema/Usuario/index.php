<?php

require '../../Config.php';

\define('MODULO', 'Usuario');

echo (new \Sappiens\Sistema\Usuario\UsuarioController())->controle(\filter_input(\INPUT_GET, 'acao'));
