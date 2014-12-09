<?php

define('MODULO', 'Login');

require '../../Config.php';

echo (new \Pixel\Login\LoginController())->controle(\filter_input(\INPUT_POST, 'acao'));

?>
