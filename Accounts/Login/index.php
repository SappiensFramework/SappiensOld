<?php

session_start();
session_destroy();

require '../../Config.php';

echo (new \Sappiens\Accounts\Login\LoginController())->controle(\filter_input(\INPUT_POST, 'acao'));

?>
