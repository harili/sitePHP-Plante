<?
    class Sensibles{
        private $sensibles= [];
        
        public function __construct($array)
        {
            if(is_array($array)){
                $this->sensibles=$array;
            }
        }
        public function getSensibles()
        {
            return $this->sensibles;
        }
    
        public function setSensibles($sensibles)
        {
            $this->sensibles = $sensibles;
        }
    
    
        
    }
?>