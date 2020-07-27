<?php

class intervenants{
    
    private $lesIntervenants = [];
    
    public function _construct($array){
        if (is_array($array)){
            $this->lesIntervenants = $array;
        }
    }
    
    
    public function cherchelesUtilisateurs($unIdUtilisateur){
        $i =0;
        while ($unIdUtilisateur != $this->lesIntervenants[$i]->getIdUtilisateur() && $i < count($this->lesIntervenants)-1){
            $i++;
        }
        if($unIdUtilisateur == $this->lesIntervenants[$i]->getIdUtilisateur()){
            return $this->lesIntervenants[$i];
        }
    }
    public function getLesIntervenants()
    {
        return $this->lesIntervenants;
    }

    public function setLesIntervenants($lesIntervenants)
    {
        $this->lesIntervenants = $lesIntervenants;
    }

}