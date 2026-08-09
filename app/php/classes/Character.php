<?php

class Character
{
    private $skinName;
    private $displayName;

    public function __construct($params){
        foreach($params as $item => $value){
            $setter = "set".ucfirst($item);

            if(method_exists($this, $setter)){
                $this->$setter($value);
            }
        }
    }

    public function getSkinName(){
        return $this->skinName;
    }

    public function getDisplayName(){
        return $this->displayName;
    }

    public function setSkinName($skinName){
        $this->skinName = $skinName;
    }

    public function setDisplayName($displayName){
        $this->displayName = $displayName;
    }

    public function toJSON(){
        return json_encode($this->ToArray());
    }

    public function ToArray(){
        $parameters = array();
        $keys = [
            "skinName",
            "displayName",
        ];
        foreach($keys as $key){
            $parameters[$key] = $this->{"get". ucfirst($key)}();
        }
        return $parameters;
    }
}