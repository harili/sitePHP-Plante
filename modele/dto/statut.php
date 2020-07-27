<?php
class Statut {
    use Hydrate;
    private $codeStatut;
    private $libelleStatut;
    
    public function __construct($unCodeStatut, $unNomOrgane){
        $this->codeStatut = $unCodeStatut;
        $this->libelleStatut = $unNomOrgane;
    }
    public function getCodeStatut()
    {
        return $this->codeStatut;
    }

    public function getLibelleStatut()
    {
        return $this->libelleStatut;
    }

    public function setCodeStatut($codeStatut)
    {
        $this->codeStatut = $codeStatut;
    }

    public function setLibelleStatut($libelleStatut)
    {
        $this->libelleStatut = $libelleStatut;
    }

    
    
    
}