<?php
require '../../Config.php';
exit;
 
try {
    
    $formModulo = new \Sappiens\Grupo\Modulo\Modulo();
    $form = $formModulo->getFormSmart();
    //$form->validar();

} catch (Exception $ex) {
    exit($ex->getMessage());
}

$UrlBaseStatic  = "//static.sappiens.com.br";
	
?>
<!DOCTYPE html>
<html lang="pt-BR" >
<head>
<style>

</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" type="text/css" media="screen" href="<?=$UrlBaseStatic;?>/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=$UrlBaseStatic?>/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=$UrlBaseStatic?>/css/smartadmin-production.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=$UrlBaseStatic?>/css/smartadmin-rtl.min.css">
<link rel="stylesheet" href="<?=$UrlBaseStatic?>/fonts/fonts.css">
<script src="<?=$UrlBaseStatic?>/js/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/libs/jquery-ui/1.10.3/jquery-ui.min.js"></script>
</head>
<body>
<div class="widget-body no-padding">	

        
        
        <?=$form->montaForm();?>
    
    
</div>
<script src="<?=$UrlBaseStatic?>/js/app.config.js"></script>
<script src="<?=$UrlBaseStatic?>/js/bootstrap/bootstrap.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/notification/SmartNotification.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/plugin/jquery-validate/jquery.validate.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/plugin/select2/select2.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
<script src="<?=$UrlBaseStatic?>/js/app.min.js"></script>
<script type="text/javascript">
	// DO NOT REMOVE : GLOBAL FUNCTIONS!
	$(document).ready(function() {
		pageSetUp();
	})
</script>
<script type="text/javascript">
<?php
    echo $form->javascript()->getLoad();
?>
</script>
</body>
</html>
