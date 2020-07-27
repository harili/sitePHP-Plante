<?php

class Traitements{
    private $traitements=array();

    public function __construct($array)
    {
        if(is_array($array)){
            $this->traitements=$array;
        }
    }

    public function chercheTraitement($unIdTraitement){
        $i=0;
        while($unIdTraitement!=$this->traitements[$i]->getIdTraitement() && $i<count($this->traitements)-1){
            $i++;
        }

        if($unIdTraitement==$this->traitements[$i]-getIdTraitement()){
            return $this->traitements[$i];
        }
    }

    /**
     * Get the value of traitements
     */ 
    public function getTraitements()
    {
            return $this->traitements;
    }
}