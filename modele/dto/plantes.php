<?php
    class Plantes{
        private $plantes=array();

        public function __construct($array)
        {
            if(is_array($array)){
                $this->plantes=$array;
            }
        }
        

        /**
         * Get the value of plantes
         */ 
        public function getLesPlantes()
        {
                return $this->plantes;
        }

        public function cherchePlante($unIdPlante){
            $i=0;
            while($unIdPlante!=$this->plantes[$i]->getIdPlante() && $i<count($this->plantes)-1){
                $i++;
            }

            if($unIdPlante==$this->plantes[$i]->getIdPlante()){
                return $this->plantes[$i];
            }
        }
    }