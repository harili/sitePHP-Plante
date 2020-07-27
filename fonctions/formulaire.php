<?php
class Formulaire{
	private $method;
	private $action;
	private $nom;
	private $style;
	private $formulaireToPrint;
	
	private $ligneComposants = array();
	private $tabComposants = array();
	
	public function __construct($uneMethode, $uneAction , $unNom,$unStyle ){
		$this->method = $uneMethode;
		$this->action =$uneAction;
		$this->nom = $unNom;
		$this->style = $unStyle;
	}
	
	
	public function concactComposants($unComposant , $autreComposant ){
		$unComposant .=  $autreComposant;
		return $unComposant ;
	}
	
	public function ajouterComposantLigne($unComposant){
		$this->ligneComposants[] = $unComposant;
	}
	
	public function ajouterComposantTab(){
		$this->tabComposants[] = $this->ligneComposants;
		$this->ligneComposants = array();
	}
	
	
	public function creerMap(string $long, string $lat){
	    $composant = "<iframe  width='600' height='450' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'
        src=\"https://maps.google.com/maps?q='+".$long."+','+".$lat."+'&hl=es&z=14&amp;output=embed\"></iframe>";
	    return $composant;
	    //\"https://maps.google.com/maps?q='+".$lat."+','+".$long."+'&hl=es&z=14&amp;output=embed\"
	    //<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2829.636609347456!2d".$lat."!3d".$long."!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDTCsDQ5JzQ0LjMiTiAwwrAzMyc1Mi41IkU!5e0!3m2!1sfr!2sfr!4v1573224428311!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
	}
	
	public function creerLabel($unLabel){
		$composant = "<label>" . $unLabel . "</label>";
		return $composant;
	}
	
	public function creerTitre($unTitre){
	    $composant = "<h1 class='titre'>" . $unTitre . "</h1>";
	    return $composant;
	}
	
	public function creerTitreH3($unTitre){
	    $composant = "<h3 class='titre'>" . $unTitre . "</h3>";
	    return $composant;
	}
	
	public function creerMessage($unMessage){
	    $composant = "<div class='message'>" . $unMessage . "</div>";
	    return $composant;
	}
	
	
	public function creerLabelId($unLabel, $unId){
	    $composant = "<label id = '".$unId."'>" . $unLabel . "</label>";
	    return $composant;
	}
	
	public function creerInputTexte($unNom, $unId, $uneValue , $required , $placeholder , $pattern){
		$composant = "
            <input type = 'text' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($uneValue)){
			$composant .= "value = '" . $uneValue . "' ";
		}
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ( !empty($required)){
			$composant .= " required ";
		}
		if (!empty($pattern)){
			$composant .= "pattern = '" . $pattern . "' ";
		}
		$composant .= "/>";
		return $composant;
	}
	
	
	public function creerInputNumber($unNom, $unId, $uneValue , $required , $placeholder , $step){
	    $composant = "
            <input type = 'number' name = '" . $unNom . "' id = '" . $unId . "' ";
	    if (!empty($uneValue)){
	        $composant .= "value = '" . $uneValue . "' ";
	    }
	    if (!empty($placeholder)){
	        $composant .= "placeholder = '" . $placeholder . "' ";
	    }
	    if ( !empty($required)){
	        $composant .= " required ";
	    }
	    if (!empty($step)){
	        $composant .= "step = '" . $step . "' ";
	    }
	    $composant .= "/>";
	    return $composant;
	}
	
	
	
	public function creerTextArea($unId,  $placeholder, $name, $required, $value){
	    $composant = "<textarea id='" . $unId . "' 
            name = '" . $name ."' ";
	    if (!empty($placeholder)){
	        $composant .= "placeholder = '" . $placeholder . "' ";
	    }
	    if ( !empty($required)){
	        $composant .= "required";
	    }
	    $composant .= "> ".$value."</textarea>";
	    return $composant;
	}
	
	public function creerInputTexte1($unNom, $unId, $unLabel, $uneValue , $required , $placeholder, $readonly){
	    $composant = "
            <label for = '" . $unNom . "'>" . $unLabel . "</label>";
	    $composant .= "<input type = 'text' name = '" . $unNom . "' id = '" . $unId . "' ";
	    if (!empty($uneValue)){
	        $composant .= "value = '" . $uneValue . "' ";
	    }
	    if (!empty($placeholder)){
	        $composant .= "placeholder = '" . $placeholder . "' ";
	    }
	    if (!empty($required)){
	        $composant .= " required";
	    }
	    if (!empty($readonly)){
	        $composant .= " readonly";
	    }
	    $composant .= "/>";
	    return $composant;
	}

	
	
	public function creerInputMdp($unNom, $unId,  $required , $placeholder , $pattern){
		$composant = "
            <input type = 'password' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ( $required = 1){
			$composant .= " required ";
		}
		if (!empty($pattern)){
			$composant .= "pattern = '" . $pattern . "' ";
		}
		$composant .= "/>";
		return $composant;
	}
	
	public function creerLabelFor($unFor,  $unLabel){
		$composant = "
        <label for='" . $unFor . "'>" . $unLabel . "</label>";
		return $composant;
	}
	
	

	public function creerSelect($unNom, $unId, $unLabel, $options){
		$composant = "<select  name = '" . $unNom . "' id = '" . $unId . "' >";
		foreach ($options as $option){
			$composant .= "<option value = '".$option[1]."'>".$option[1]."</option>";
		}
		$composant .= "</select></td></tr>";
		return $composant;
	}	
	
	public function creerSelect2($unNom, $unId, $options){
	    $composant = "<select  name = '" . $unNom . "' id = '" . $unId . "' >";
	    foreach ($options as $option){
	        $composant .= "<option value = '".$option[0]."'>".$option[1]."</option>";
	    }
	    $composant .= "</select></td></tr>";
	    return $composant;
	}
	
	public function creerSelectIndicé($unNom, $unId, $unLabel, $options){
	    $composant = "<select  name = '" . $unNom . "' id = '" . $unId . "' >";
	    foreach ($options as $option){
	        $composant .= "<option value = '".$option[0]."'>".$option[1]."</option>";
	    }
	    $composant .= "</select></td></tr>";
	    return $composant;
	}
	
	public function ajouterSelect($id, $name, $tablo, $selected, $disabled){
	    $select ="<select id='".$id."' name='".$name."'";
	    if(!empty($disabled)){
	        $select .= " disabled ";
	    }
	    $select .= ">";
	    foreach($tablo as $ligne){
	        $select .= "<option value='";
	        $select .= $ligne[0]."'";
	        
	        if($ligne[1]==$selected){
	            $select .= "selected='selected'";
	        }
	        $select .= ">";
	        $select .= $ligne[1] ."</option>";
	    }
	    $select .= "</select>";
	    return $select;
	}
	
	public function creerInputSubmit($unNom, $unId, $uneValue){
		$composant = "<input type = 'submit' name = '" . $unNom . "' id = '" . $unId . "' ";
		$composant .= "value = '" . $uneValue . "'  /> ";
		return $composant;
	}
	
	
	public function creerLien($unLien, $uneValeur){
	    $composant = "<a href='". $unLien ."'>". $uneValeur."</a>";
	    return $composant;
	}
	
	public function creerInputReset($unNom, $unId, $uneValue){
	    $composant = "<input type = 'reset' name = '" . $unNom . "' id = '" . $unId . "' ";
	    $composant .= "value = '" . $uneValue . "'/> ";
	    return $composant;
	}

	public function creerInputImage($unNom, $unId, $uneSource){
		$composant = "<input type = 'image' name = '" . $unNom . "' id = '" . $unId . "' ";
		$composant .= " src = '" . $uneSource . "'/> ";
		return $composant;
	}
	
	public function creerImage($uneSource, $unAlt){
	    $composant = "<div class='image'><img src ='images/".$uneSource."' alt= '".$unAlt."'></div>";
	    return $composant;
	}
	
	public function creerCorps($unTexte){
	    $composant = "<div class='corps'>
                        <p>".$unTexte."</p>
                    </div>";
	    return $composant;
	}
	
	public function creerInputHidden($unNom, $unId, $uneValue){
	    $composant = "<input type = 'hidden' name = '" . $unNom . "' id = '" . $unId . "' ";
	    $composant .= "value = '" . $uneValue . "'/> ";
	    return $composant;
	}
	
	public function creerInputFile($unNom, $unId){
	    $composant = "<input type='file' id='".$unId."' name='".$unNom."'";
	    $composant .= " accept='.jpg'>";
	    return $composant;
	}
	
	
	
	
	public function creerFormulaire(){
		$this->formulaireToPrint = "<form method = '" .  $this->method . "' ";
		$this->formulaireToPrint .= "action = '" .  $this->action . "' ";
		$this->formulaireToPrint .= "name = '" .  $this->nom . "' ";
		$this->formulaireToPrint .= "class = '" .  $this->style . "' ENCTYPE='multipart/form-data' >";
		
	
		foreach ($this->tabComposants as $uneLigneComposants){
			$this->formulaireToPrint .= "<div class = 'ligne'>";
			foreach ($uneLigneComposants as $unComposant){
				$this->formulaireToPrint .= $unComposant ;
			}
			$this->formulaireToPrint .= "</div>";
		}
		$this->formulaireToPrint .= "</form>";
		return $this->formulaireToPrint ;
	}
	
	public function afficherFormulaire(){
		echo $this->formulaireToPrint ;
	}

	
}