<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
	
		<div class="gauche">
			<?php  include 'traitement/traitementGauche.php' ;?> 
		</div>
	
		
		<div class="droite">	
			<?php  
			
    			if(!empty($formAjoutTraitement)){
    			    include 'traitement/traitementDroiteAjouter.php' ;
    			}
    			else if(!empty($formModifTraitement)){
    			    include 'traitement/traitementDroiteModifier.php' ;
    			}
    			else if(!empty($formSupprTraitement)){
    			    include 'traitement/traitementDroiteSupprimer.php' ;
    			}
    			else if(!empty($formBioagresseurTraitement)){
    			    include 'traitement/traitementGerer.php' ;
    			}
    			else{
    			    include 'traitement/traitementDroite.php' ;
    			}
			?> 
		</div>
	</div>
    <footer>
    	<?php include 'vue/bas.php' ;?>
    </footer>
</div>