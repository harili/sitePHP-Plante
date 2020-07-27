<?php
class Ravageur extends Bioagresseur{
    use Hydrate;
    private $stadeActif;
    private $nbGeneration;
    
    public function __construct($unnbGeneration = NULL, $unstadeActif = NULL, $unIdBioAgresseur = NULL, $unNomAgresseur = NULL){
        parent::_construct($unIdBioAgresseur, $unNomAgresseur);
        $this->stadeActif = $unstadeActif;
        $this->nbGenerations = $unnbGeneration;
    }
    public function getStadeActif()
    {
        return $this->stadeActif;
    }

    public function setStadeActif($stadeActif)
    {
        $this->stadeActif = $stadeActif;
    }
    public function getNbGeneration()
    {
        return $this->nbGeneration;
    }

    public function setNbGeneration($nbGeneration)
    {
        $this->nbGeneration = $nbGeneration;
    }


}