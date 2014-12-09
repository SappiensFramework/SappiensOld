<?php

require '../Config.php';

echo (new \Sappiens\Dashboard\DashboardController())->controle(\filter_input(\INPUT_GET, 'acao'));

?>