<div class="conteneur">
	
	<header>
		<?php include 'haut.php' ;?>
	</header>

	<div class="content">
	
		<div class="gauche">
			<?php  include 'epidemiologie/epidemiologieGauche.php' ;?> 
		</div>
	
		
		<div class="droite">	
			<?php 
			if(isset($_POST['boutonModifier'])){
			    include 'epidemiologie/epidemiologieDroiteModifier.php' ;
			}else{
			    include 'epidemiologie/epidemiologieDroite.php' ;
			}
			
 ?>
		</div>
	</div>
    <footer>
    	<?php include 'vue/bas.php' ;?>
    </footer>
</div>