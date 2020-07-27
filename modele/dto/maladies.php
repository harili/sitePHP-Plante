<?php
class Maladies{
    private $Maladies= [];
    
    public function __construct($array)
    {
        if(is_array($array)){
            $this->Maladies=$array;
        }
    }
    
    
    /**
     * Get the value of Maladies
     */
    public function getLesMaladies()
    {
        return $this->Maladies;
    }
    
    public function chercheMaladie($idBioagresseur){
        $i=0;
        while($idBioagresseur!=$this->Maladies[$i]->getIdBioagresseur() && $i<count($this->Maladies)-1){
            $i++;
        }
        
        if($idBioagresseur==$this->Maladies[$i]->getIdBioagresseur()){
            return $this->Maladies[$i];
        }
    }
}