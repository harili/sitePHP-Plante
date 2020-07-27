<nav class="menuPrincipal">	
	<?php echo $monMenu; ?>
</nav>
<div class='bandeau'>
	<img src="images/bandeau.jpg" alt="Photo du bandeau du site : foret">
	<div class="message">
	<?php 
	if(isset($_SESSION['testAuthentification'])){
	    if($_SESSION['testAuthentification']== 1){
	        if(isset($_SESSION['intervenant']) && $_SESSION['intervenant']->getLogin() != null){
	            echo "Bonjour " . $_SESSION['intervenant']->getPrenomIntervenant(). " ".$_SESSION['intervenant']->getNomIntervenant()." !" ;
	        }
	    }
	}?>
	</div>
</div>