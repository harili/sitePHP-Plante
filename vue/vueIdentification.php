<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
		<div class="droite">
			<?php $formulaire->afficherFormulaire();
			if(isset($message) && !empty($message)){ echo $message; }?>		
		</div>

	</div>

	<footer>
		<?php include 'bas.php' ;?>
	</footer>
	
</div>
