<?php

class Map {

    private $id;
    private $levelname;
    private $ACT;
    private $TypeOfLevel;
    private $NextLevel;

    public function __construct($content = array()){
        foreach($content as $item => $value){
            $setter = "set".ucfirst($item);

            if(method_exists($this, $setter)){
                $this->$setter($value);
            }
        }
    }

    public function getID(){
        return $this->id;
    }

    public function getLevelname(){
        return $this->levelname;
    }

    public function getACT(){
        return $this->ACT;
    }

    public function getTypeOfLevel(){
        return $this->TypeOfLevel;
    }

    public function getNextLevel(){
        return $this->NextLevel;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function setLevelname($levelname){
        $this->levelname = $levelname;
    }

    public function setACT($ACT){
        $this->ACT = $ACT;
    }

    public function setTypeOfLevel($TypeOfLevel){
        $this->TypeOfLevel = $TypeOfLevel;
    }

    public function setNextLevel($NextLevel){
        $this->NextLevel = $NextLevel;
    }

    public function ToJSON(){
        $parameters = array();

        $keys = [
            "id",
            "levelname",
            "ACT",
            "TypeOfLevel",
            "NextLevel"
        ];

        foreach($keys as $key){
            $parameters[$key] = $this->{"get".$key}();
        }

        return json_encode($parameters);
    }

    public function toArray(){
        $parameters = array();
        $keys = [
            "id",
            "levelname",
            "ACT",
            "TypeOfLevel",
            "NextLevel"
        ];
        foreach($keys as $key){
            $parameters[$key] = $this->{"get".$key}();
        }
        return $parameters;
    }
}