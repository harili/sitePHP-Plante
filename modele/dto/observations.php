<?php

class Observations{
    
    private $observations = array();
    
    public function __construct($array){
        
        if (is_array($array)){
            
            $this->observations = $array;
        }
    }
    
    //Fonction qui permet de retourner un tableau d'observations
    
    public function getLesObservations(){
        return $this->observations;
    }
    
    //Fonction qui permet de trouver une observation à partir de sa clé primaire composée
    
    public function cherchelesObservations($unIdIntervenant, $unIdBioAgresseur, $unIdPlante, $date){
        $i =0;
        while ($unIdIntervenant!=$this->observations[$i]->getIdIntervenant() && $unIdBioAgresseur != $this->observations[$i]->getIdBioAgresseur() && $unIdPlante!=$this->observations[$i]->getIdPlante() && $date!=$this->observations[$i]->getDate() && $i < count($this->observations)-1){
            $i++;
        }
        if($unIdIntervenant==$this->observations[$i]->getIdIntervenant() && $unIdBioAgresseur == $this->observations[$i]->getIdBioAgresseur() && $unIdPlante==$this->observations[$i]->getIdPlante() && $date==$this->observations[$i]->getDate()){
            return $this->observations[$i];
        }
    }
}