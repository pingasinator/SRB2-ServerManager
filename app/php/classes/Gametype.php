<?php

class Gametype
{
    private $name = "";
    private $identifier = "";

    private $typeOfLevel = array();

    public function __construct($params){
        foreach($params as $item => $value){
            $setter = "set".ucfirst($item);

            if(method_exists($this, $setter)){
                $this->$setter($value);
            }
        }
    }

    public function getName(){
        return $this->name;
    }

    public function getIdentifier(){
        return $this->identifier;
    }

    public function getTypeOfLevel(){
        return $this->typeOfLevel;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setIdentifier($identifier){
        $this->identifier = $identifier;
    }

    public function setTypeOfLevel($typeOfLevel){
        $this->typeOfLevel = $typeOfLevel;
    }

    public function ToArray(){
        $parameters = array();
        $keys = [
            "name",
            "identifier",
            "TypeOfLevel"
        ];
        foreach($keys as $key){
            $parameters[$key] = $this->{"get".$key}();
        }
        return $parameters;
    }

    public function ToJSON(){
        return json_encode($this->ToArray());
    }
}