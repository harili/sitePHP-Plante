<?php
class Traitement {
    use Hydrate;
    private $idTraitement;
    private $nomTraitement;
    private $descriptifTraitement;
    
    public function __construct($unId  = NULL, $unNom = NULL){
        $this->idTraitement = $unId;
        $this->nomTraitement = $unNom;
    }
    public function getIdTraitement()
    {
        return $this->idTraitement;
    }

    public function getNomTraitement()
    {
        return $this->nomTraitement;
    }

    public function getDescriptifTraitement()
    {
        return $this->descriptifTraitement;
    }

    public function setIdTraitement($idTraitement)
    {
        $this->idTraitement = $idTraitement;
    }

    public function setNomTraitement($nomTraitement)
    {
        $this->nomTraitement = $nomTraitement;
    }

    public function setDescriptifTraitement($descriptifTraitement)
    {
        $this->descriptifTraitement = $descriptifTraitement;
    }

    
}