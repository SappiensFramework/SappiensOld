<?php

session_start();
session_destroy();

header('location: ../Login?err=Desconectado em segurança!');

?>
