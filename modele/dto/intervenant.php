<?php
class Intervenant {
    use Hydrate;
    private $idIntervenant;
    private $login;
    private $mdp;
    private $codeStatut;
    private $nomIntervenant;
    private $prenomIntervenant;
    
    public function __construct($unId = NULL, $unLogin = NULL, $unmdp = NULL, $unstatut = NULL, $nomIntervenant = null, $prenomIntervenant = null){
        $this->idIntervenant = $unId;
        $this->login = $unLogin;
        $this->codeStatut = $unstatut;
        $this->mdp = $unmdp;
        $this->nomIntervenant = $nomIntervenant;
        $this->prenomIntervenant = $prenomIntervenant;
    }
   
    public function getLogin()
    {
        return $this->login;
    }

    public function getMdp()
    {
        return $this->mdp;
    }

    public function getCodeStatut()
    {
        return $this->codeStatut;
    }



    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    public function setCodeStatut($codeStatut)
    {
        $this->codeStatut = $codeStatut;
    }
    public function getIdIntervenant()
    {
        return $this->idIntervenant;
    }

    public function setIdIntervenant($idIntervenant)
    {
        $this->idIntervenant = $idIntervenant;
    }
    
    public function getNomIntervenant()
    {
        return $this->nomIntervenant;
    }

    public function getPrenomIntervenant()
    {
        return $this->prenomIntervenant;
    }

    public function setNomIntervenant($nomIntervenant)
    {
        $this->nomIntervenant = $nomIntervenant;
    }

    public function setPrenomIntervenant($prenomIntervenant)
    {
        $this->prenomIntervenant = $prenomIntervenant;
    }



    
}