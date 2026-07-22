<?php



class server{
    private $name;
    private $Map;
    private $port;
    private $Mods = array();
    private $GameType;

    private $maxPlayers;

    public function __construct($params){
        foreach ($params as $name => $value) {
            if (method_exists($this, 'set'.$name)) {
                $this->{"set".$name}($value);
            }
        }
        return $this;
    }

    public function ToJSON(){
        $parameters = array();

        $keys = [
            "Name",
            "Map",
            "Port",
            "Mods",
            "GameType",
            "MaxPlayers"
        ];

        foreach($keys as $key){
            $parameters[$key] = $this->{"get".$key}();
        }

        return json_encode($parameters);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMap(){
        return $this->Map;
    }

    public function getPort(){
        return $this->port;
    }

    public function getMaxPlayers()
    {
        return $this->maxPlayers;
    }

    public function getMods(){
        return $this->Mods;
    }

    public function getGameType(){
        return $this->GameType;
    }

    // Setters

    public function setName($name){
        $this->name = $name;
    }

    public function setPort($port){
        $this->port = $port;
    }

    public function setMaxPlayers($maxPlayers){
        $this->maxPlayers = $maxPlayers;
    }

    public function setMap($Map){
        $this->Map = $Map;
    }

    public function setGameType($GameType){
        $this->GameType = $GameType;
    }
}