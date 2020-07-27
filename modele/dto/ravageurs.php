<?php
class Ravageurs{
    private $ravageurs= [];
    
    public function __construct($array)
    {
        if(is_array($array)){
            $this->ravageurs=$array;
        }
    }
    
    
    /**
     * Get the value of ravageurs
     */
    public function getLesRavageurs()
    {
        return $this->ravageurs;
    }
    
    public function chercheRavageur($idBioagresseur){
        $i=0;
        while($idBioagresseur!=$this->ravageurs[$i]->getIdBioagresseur() && $i<count($this->ravageurs)-1){
            $i++;
        }
        
        if($idBioagresseur==$this->ravageurs[$i]->getIdBioagresseur()){
            return $this->ravageurs[$i];
        }
    }
}