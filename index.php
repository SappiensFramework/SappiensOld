<?php

require './Config.php';

if($_SESSION['usuarioCod'] and $_SESSION['organogramaCod']) {
	header('location: ./Dashboard');
} else {
	header('location: ./Accounts/Login?err='.$_GET['err']);
}

?>