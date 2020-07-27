<?
class Traiters{
    private $traiters= [];
    
    public function __construct($array)
    {
        if(is_array($array)){
            $this->traiters=$array;
        }
    }
    public function getTraiters()
    {
        return $this->traiters;
    }
    
    public function setTraiters($traiters)
    {
        $this->traiters = $traiters;
    }
    
    
    
}
?>