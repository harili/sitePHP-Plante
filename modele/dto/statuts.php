<?
class Statuts{
    private $statuts= [];
    
    public function __construct($array)
    {
        if(is_array($array)){
            $this->statuts=$array;
        }
    }
    

    public function getStatuts()
    {
        return $this->statuts;
    }

    public function setStatuts($statuts)
    {
        $this->statuts = $statuts;
    }

}
?>