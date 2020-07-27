<?php
class BioAgresseur{
    
    use Hydrate;
    private $idBioagresseur;
    private $nomBioagresseur;
    private $periodeRisqueBioagresseur;
    private $symptomeBioagresseur;
    private $stadeSensibleBioagresseur;
    
    public function _construct($unIdBioAgresseur = NULL, $unNomAgresseur = NULL, $periode = NULL, $sympt = NULL, $stade = NULL)
    {
        $this->idBioagresseur = $unIdBioAgresseur;
        $this->nomBioAgresseur = $unNomAgresseur;
        $this->symptomesBioagresseur = $sympt;
        $this->periodeRisqueBioagresseur = $periode;
        $this->stadeSensibleBioagresseur = $stade;
    }
    public function getIdBioagresseur()
    {
        return $this->idBioagresseur;
    }

    public function getNomBioagresseur()
    {
        return $this->nomBioagresseur;
    }

    public function getPeriodeRisqueBioagresseur()
    {
        return $this->periodeRisqueBioagresseur;
    }

    public function getSymptomeBioagresseur()
    {
        return $this->symptomeBioagresseur;
    }

    public function getStadeSensibleBioagresseur()
    {
        return $this->stadeSensibleBioagresseur;
    }

    public function setIdBioagresseur($idBioagresseur)
    {
        $this->idBioagresseur = $idBioagresseur;
    }

    public function setNomBioagresseur($nomBioagresseur)
    {
        $this->nomBioagresseur = $nomBioagresseur;
    }

    public function setPeriodeRisqueBioagresseur($periodeRisqueBioagresseur)
    {
        $this->periodeRisqueBioagresseur = $periodeRisqueBioagresseur;
    }

    public function setSymptomeBioagresseur($symptomeBioagresseur)
    {
        $this->symptomeBioagresseur = $symptomeBioagresseur;
    }

    public function setStadeSensibleBioagresseur($stadeSensibleBioagresseur)
    {
        $this->stadeSensibleBioagresseur = $stadeSensibleBioagresseur;
    }


     
}