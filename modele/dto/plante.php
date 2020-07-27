<?php

class Plante{
    use Hydrate;
    private $idPlante;
    private $nomPlante;
    private $descriptifPlante;
    
    public function __construct($unIdPlante = NULL, $unNomPlante = NULL, $descriptifPlante = NULL){
        $this->idPlante = $unIdPlante;
        $this->nomPlante = $unNomPlante;
        $this->descriptifPlante = $descriptifPlante;
    }
    public function getIdPlante()
    {
        return $this->idPlante;
    }

    public function getNomPlante()
    {
        return $this->nomPlante;
    }

    public function getDescriptifPlante()
    {
        return $this->descriptifPlante;
    }


    public function setIdPlante($idPlante)
    {
        $this->idPlante = $idPlante;
    }

    public function setNomPlante($nomPlante)
    {
        $this->nomPlante = $nomPlante;
    }

    public function setDescriptifPlante($descriptifPlante)
    {
        $this->descriptifPlante = $descriptifPlante;
    }


    

    
    
}