<?php

class Fonctions{
	public static function creerInputSubmit($unNom, $unId, $uneValue){
        $composant = "<input type = 'submit' class = '".$unNom."' name = '" . $unNom . "' id = '" . $unId . "' ";
        $composant .= "value = '" . $uneValue . "'/> ";
        return $composant;
    }

	public static function creerInputHidden($unNom, $unId, $uneValue){
        $composant = "<input type = 'hidden' name = '" . $unNom . "' id = '" . $unId . "' ";
        $composant .= "value = '" . $uneValue . "'/> ";
        return $composant;
    }
    
}

