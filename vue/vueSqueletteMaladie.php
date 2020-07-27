<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
	
		<div class="gauche">
			<?php  include 'maladie/maladieGauche.php' ;?> 
		</div>
		
		<div class="droite">	
			<?php 
			if(!empty($formAjoutMaladie)){
			    include 'maladie/maladieDroiteAjouter.php' ;
			}
			else if(!empty($formModifMaladie)){
			    include 'maladie/maladieDroiteModifier.php' ;
			}
			else if(!empty($formSupprMaladie)){
			    include 'maladie/maladieDroiteSupprimer.php' ;
			}
			else if(!empty($formPlanteMaladie)){
			    include 'maladie/maladieGerer.php' ;
			}
			else{
			    include 'maladie/maladieDroite.php' ;
			}?> 
		</div>
	</div>
	<footer>
			<?php include 'vue/bas.php' ;?>
	</footer>
	
</div>