<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	<main>
		<div class="gauche">
			<?php  include 'compte/compteGauche.php' ;?> 
		</div>
		<div class='droite'>
		<br/>
			<?php $formGestionCompte->afficherFormulaire();?>
		</div>
	</main>
	<footer>
		<?php include 'bas.php' ;?>
	</footer>
</div>