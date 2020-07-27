<?php
class Organe {
    use Hydrate;
    private $idOrgane;
    private $nomOrgane;
    
    public function __construct($unIdOrgane = NULL, $unNomOrgane = NULL){
        $this->idOrgane = $unIdOrgane;
        $this->nomOrgane = $unNomOrgane;
    }
    public function getIdOrgane()
    {
        return $this->idOrgane;
    }

    public function getNomOrgane()
    {
        return $this->nomOrgane;
    }

    public function setIdOrgane($idOrgane)
    {
        $this->idOrgane = $idOrgane;
    }

    public function setNomOrgane($nomOrgane)
    {
        $this->nomOrgane = $nomOrgane;
    }

    

}