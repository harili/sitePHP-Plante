<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
	
		<div class="gauche">
			<?php  include 'organe/organeGauche.php' ;?> 
		</div>
	
		
		<div class="droite">	
			<?php  
			
    			if(!empty($formAjoutOrgane)){
    			    include 'organe/organeDroiteAjouter.php' ;
    			}
    			else if(!empty($formModifOrgane)){
    			    include 'organe/organeDroiteModifier.php' ;
    			}
    			else if(!empty($formSupprOrgane)){
    			    include 'organe/organeDroiteSupprimer.php' ;
    			}
    			else if(!empty($formBioagresseurOrgane)){
    			    include 'organe/organeGerer.php' ;
    			}
    			else{
    			    include 'organe/organeDroite.php' ;
    			}
			?> 
		</div>
	</div>
    <footer>
    	<?php include 'vue/bas.php' ;?>
    </footer>
</div>