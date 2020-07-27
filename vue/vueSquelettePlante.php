<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
	
		<div class="gauche">
			<?php  include 'plante/planteGauche.php' ;?> 
		</div>
	
		
		<div class="droite">	
			<?php  
			
    			if(!empty($formAjoutPlante)){
    			    include 'plante/planteDroiteAjouter.php' ;
    			}
    			else if(!empty($formModifPlante)){
    			    include 'plante/planteDroiteModifier.php' ;
    			}
    			else if(!empty($formSupprPlante)){
    			    include 'plante/planteDroiteSupprimer.php' ;
    			}
    			else if(!empty($formBioagresseurPlante)){
    			    include 'plante/planteGerer.php' ;
    			}
    			else{
    			    include 'plante/planteDroite.php' ;
    			}
			?> 
		</div>
	</div>
    <footer>
    	<?php include 'vue/bas.php' ;?>
    </footer>
</div>