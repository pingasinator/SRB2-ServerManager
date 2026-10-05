<?php



class server{
    private $name;
    private $displayName = "";
    private $MOTD;
    private $maxPlayers;
    private $gameType;
    private $map;

    private $timeLimit = 10;
    private $pointLimit;
    private $forceCharacter = "None";

    private $port;
    private $password = "";
    private $Room = "00";
    private $masterServer = "https://mb.srb2.org/MS/0";
    private $AllowDownload = "";
    private $downloadSize = 1;

    private $Mods = array();

    public function __construct($params){
        foreach ($params as $name => $value) {
            if (method_exists($this, 'set'.$name)) {

                $this->{"set".$name}($value);
            }
        }
        return $this;
    }

    public function ToJSON(){

        return json_encode($this->ToArray());
    }

    public function ToArray(){
        $parameters = array();

        $keys = $this->getVars();

        foreach($keys as $key){
            $parameters[ucfirst($key->name)] = $this->{"get".ucfirst($key->name)}();
        }

        return $parameters;
    }

    public function getName(){
        return $this->name;
    }

    public function getDisplayName(){
        return $this->displayName;
    }

    public function getMOTD(){
        return $this->MOTD;
    }

    public function getMaxPlayers(){
        return $this->maxPlayers;
    }

    public function getGameType(){
        return $this->gameType;
    }

    public function getMap(){
        return $this->map;
    }

    public function getTimeLimit(){
        return $this->timeLimit;
    }

    public function getPointLimit(){
        return $this->pointLimit;
    }

    public function getForceCharacter(){
        return $this->forceCharacter;
    }

    public function getPort(){
        return $this->port;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getMasterServer(){
        return $this->masterServer;
    }

    public function getRoom(){
        return $this->Room;
    }

    public function getAllowDownload(){
        return $this->AllowDownload;
    }

    public function getDownloadsize(){
        return $this->downloadSize;
    }

    public function getMods(){
        return $this->Mods;
    }

    // Setters

    public function setName($name){
        $this->name = $name;
    }

    public function setDisplayName($displayName){
        if($displayName != ""){
            $this->displayName = $displayName;
        }else{
            $this->displayName = $this->name;
        }
    }

    public function setMOTD($MOTD){
        $this->MOTD = $MOTD;
    }

    public function setMaxPlayers($maxPlayers){
        $this->maxPlayers = $maxPlayers;
    }

    public function setGameType($GameType){
        $this->gameType = $GameType;
    }

    public function setMap($Map){
        $this->map = $Map;
    }

    public function setTimeLimit($TimeLimit){
        $this->timeLimit = $TimeLimit;
    }

    public function setPointLimit($PointLimit)
    {
        $this->pointLimit = $PointLimit;
    }

    public function setForceCharacter($forceCharacter){
        $this->forceCharacter = $forceCharacter;
    }

    public function setPort($port){
        $this->port = $port;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setMasterServer($masterServer){
        $this->masterServer = $masterServer;
    }

    public function setRoom($Room){
        $this->Room = $Room;
    }

    public function setAllowDownload($AllowDownload){
        $this->AllowDownload = $AllowDownload;
    }

    public function setDownloadSize($Downloadsize){
        $this->downloadSize = $Downloadsize;
    }

    public function setMods($Mods){
        $this->Mods = $Mods;
    }

    public function addMod($ModName){
        $this->Mods[] = $ModName;
    }

    public function getVars(){
        $reflection = new ReflectionClass($this);
        return $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
    }
}