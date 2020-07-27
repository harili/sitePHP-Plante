<?php
class Sensible {
    use Hydrate;
    
    private $idBioagresseur;
    private $idPlante;
    
    public function __construct($idBioagresseur = NULL, $idPlante = NULL){
        $this->idBioagresseur = $idBioagresseur;
        $this->idPlante = $idPlante;
    }
    
    public function getIdBioagresseur()
    {
        return $this->idBioagresseur;
    }

    public function getIdPlante()
    {
        return $this->idPlante;
    }

    public function setIdBioagresseur($idBioagresseur)
    {
        $this->idBioagresseur = $idBioagresseur;
    }

    public function setIdPlante($idPlante)
    {
        $this->idPlante = $idPlante;
    }

      
    
    
    
}