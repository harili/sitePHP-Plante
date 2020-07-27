<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
	
		<div class="gauche">
			<?php  include 'ravageur/ravageurGauche.php' ;?> 
		</div>
		
		<div class="droite">	
			<?php 
			if(!empty($formAjoutRavageur)){
			    include 'ravageur/ravageurDroiteAjouter.php' ;
			}
			else if(!empty($formModifRavageur)){
			    include 'ravageur/ravageurDroiteModifier.php' ;
			}
			else if(!empty($formSupprRavageur)){
			    include 'ravageur/ravageurDroiteSupprimer.php' ;
			}
			else if(!empty($formPlanteRavageur)){
			    include 'ravageur/ravageurGerer.php' ;
			}
			else{
			    include 'ravageur/ravageurDroite.php' ;
			}?> 
		</div>
	</div>
	<footer>
			<?php include 'vue/bas.php' ;?>
	</footer>
	
</div>