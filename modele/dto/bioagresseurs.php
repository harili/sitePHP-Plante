<?php

class BioAgresseurs{
    
    private $lesBioagresseurs = [];
    
    public function __construct($array){
        if (is_array($array)){
            $this->bioAgresseurs = $array;
        }
    }
        
    
    public function cherchelesBioAgresseurs($unIdBioAgresseur){
        $i =0;
        while ($unIdBioAgresseur != $this->bioAgresseurs[$i]->getIdBioAgresseur() && $i < count($this->bioAgresseurs)-1){
            $i++;
        }
        if($unIdBioAgresseur == $this->bioAgresseurs[$i]->getIdBioAgresseur()){
            return $this->bioAgresseurs[$i];
        }
    }
    public function getLesBioagresseurs()
    {
        return $this->lesBioagresseurs;
    }

    public function setLesBioagresseurs($lesBioagresseurs)
    {
        $this->lesBioagresseurs = $lesBioagresseurs;
    }

}