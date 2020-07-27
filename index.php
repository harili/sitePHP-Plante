<?php  
require 'fonctions/monLoader.php';
session_start()?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>
		<title>IFRA</title>
		<style type="text/css">
			@import url(styles/ifra.css);
		</style>
	
	</head>
	<body >
		<?php
			require_once 'controleur/controleurPrincipal.php';
		?>
	</body>
</html>
<?php //var_dump($_SESSION);?>
