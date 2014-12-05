<?php

require '../../Config.php';

$dependencia = new \Pixel\Remoto\Dependencia();
echo $dependencia->montaDependencia(\filter_input(\INPUT_GET, 'm'), \filter_input(\INPUT_GET, 'c'), \filter_input(\INPUT_GET, 'r'), \filter_input(\INPUT_GET, 'n'));
