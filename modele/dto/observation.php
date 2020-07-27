<?php
class Observation{
    
    use Hydrate;
    private $idObservation;
    private $idIntervenant;
    private $idBioAgresseur;
    private $idPlante;
    private $date;
    private $coordonneeObservation;
    private $libObservation;

    
    
    
    //Constructeur d'Observation
    
    public function __construct($idObser = null,$id=NULL, $idbio=NULL, $idPlan=NULL, $da=NULL, $coo=NULL, $lib=NULL, $dep=NULL)
    {
        $this->idObservation = $idObser;
        $this->idIntervenant=$id;
        $this->idBioAgresseur=$idbio;
        $this->idPlante=$idPlan;
        $this->date=$da;
        $this->coordonneeObservation=$coo;
        $this->libObservation=$lib;
    }
    
    
    
    
    
    
    
    
    /**
     * Get the value of idIntervenant
     */
    public function getIdIntervenant()
    {
        return $this->idIntervenant;
    }
    
    /**
     * Set the value of idIntervenant
     *
     * @return  self
     */
    public function setIdIntervenant($idIntervenant)
    {
        $this->idIntervenant = $idIntervenant;
        
        return $this;
    }
    
    /**
     * Set the value of idBioAgresseur
     *
     * @return  self
     */
    public function setIdBioAgresseur($idBioAgresseur)
    {
        $this->idBioAgresseur = $idBioAgresseur;
        
        return $this;
    }
    
    /**
     * Get the value of idPlante
     */
    public function getIdPlante()
    {
        return $this->idPlante;
    }
    
    /**
     * Set the value of idPlante
     *
     * @return  self
     */
    public function setIdPlante($idPlante)
    {
        $this->idPlante = $idPlante;
        
        return $this;
    }
    
    /**
     * Get the value of date
     */
    public function getDateObservation()
    {
        return $this->date;
    }
    
    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDateObservation($date)
    {
        $this->date = $date;
        
        return $this;
    }
    
    /**
     * Get the value of coordonneesObservations
     */
    public function getCoordoneeObservation()
    {
        return $this->coordonneeObservation;
    }
    
    /**
     * Set the value of coordonneesObservations
     *
     * @return  self
     */
    public function setCoordoneeObservation($coordonneesObservations)
    {
        $this->coordonneeObservation = $coordonneesObservations;
        
        return $this;
    }
    
    /**
     * Get the value of libObservation
     */
    public function getLibelleObservation()
    {
        return $this->libObservation;
    }
    
    /**
     * Set the value of libObservation
     *
     * @return  self
     */
    public function setLibelleObservation($libObservation)
    {
        $this->libObservation = $libObservation;
        
        return $this;
    }
    
  
    /**
     * Get the value of idBioAgresseur
     */
    
    public function getIdBioAgresseur()
    {
        return $this->idBioAgresseur;
    }
    public function getIdObservation()
    {
        return $this->idObservation;
    }
    
    public function setIdObservation($idObservation)
    {
        $this->idObservation = $idObservation;
    }
    
}