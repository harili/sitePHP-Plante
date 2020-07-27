<?php
class Traiter {
    use Hydrate;
    
    private $idBioagresseur;
    private $idOrgane;
    
    public function __construct($idBioagresseur = NULL, $idOrgane = NULL){
        $this->idBioagresseur = $idBioagresseur;
        $this->idOrgane = $idOrgane;
    }
    
    public function getIdBioagresseur()
    {
        return $this->idBioagresseur;
    }

    public function getIdOrgane()
    {
        return $this->idOrgane;
    }

    public function setIdBioagresseur($idBioagresseur)
    {
        $this->idBioagresseur = $idBioagresseur;
    }

    public function setIdOrgane($idOrgane)
    {
        $this->idOrgane = $idOrgane;
    }

    
   
    
    
    
    
    
}