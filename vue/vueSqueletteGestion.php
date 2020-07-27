<div class="conteneur">
	<header>
		<?php include 'haut.php' ;?>
	</header>
	<div class="content">
	
		<div class="gauche">
			<?php  include 'gestion/gaucheGestion.php' ;?> 
		</div>
		
		<div class="droite">	
			<?php 
			if(!empty($formulaireInscription)){
			    include 'gestion/gestionDroiteAjouter.php' ;
			}
			else if(!empty($formModifIntervenant)){
			    include 'gestion/gestionDroiteModifier.php' ;
			}
			else if(!empty($formSupprIntervenant)){
			    include 'gestion/gestionDroiteSupprimer.php' ;
			}
			else if(!empty($formPlanteIntervenant)){
			    include 'gestion/gestionGerer.php' ;
			}
			else{
			    include 'gestion/gestionDroite.php' ;
			}?> 
		</div>
	</div>
	<footer>
		<?php include 'bas.php' ;?>
	</footer>
</div>