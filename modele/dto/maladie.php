<?php
class Maladie extends Bioagresseur{
    use Hydrate;
    
    private $conditionsFavorables;
    
    public function __construct($uneConditionFavorables = NULL, $unIdBioAgresseur = NULL, $unNomAgresseur = NULL){
        parent::_construct($unIdBioAgresseur, $unNomAgresseur);
        $this->conditionsFavorables = $uneConditionFavorables;
    }
    public function getConditionsFavorables()
    {
        return $this->conditionsFavorables;
    }

    public function setConditionsFavorables($conditionsFavorables)
    {
        $this->conditionsFavorables = $conditionsFavorables;
    }

    
}