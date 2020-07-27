<?php
class Organes{
    private $organes= [];
    
    public function __construct($array)
    {
        if(is_array($array)){
            $this->organes=$array;
        }
    }
    
    
    /**
     * Get the value of ravageurs
     */
    public function getLesOrganes()
    {
        return $this->organes;
    }
    
    public function chercheOrgane($idBioagresseur){
        $i=0;
        while($idBioagresseur!=$this->organes[$i]->getIdBioagresseur() && $i<count($this->organes)-1){
            $i++;
        }
        
        if($idBioagresseur==$this->organes[$i]->getIdBioagresseur()){
            return $this->organes[$i];
        }
    }
}