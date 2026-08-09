<?php

class Addon {
    private $name;
    private $file;
    private $characters = array();
    private $maps = array();

    private $gametypes = array();

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

    public function getCharacters():array{
        return $this->characters;
    }

    public function getMaps():array{
        return $this->maps;
    }

    public function getGametypes():array{
        return $this->gametypes;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setCharacters($characters){
        if(is_array($characters)){
            foreach($characters as $character){
                $this->characters[] = new Character($character);
            }
        }else{
            $this->characters[] = $characters;
        }
    }

    public function setMaps($maps){
        if(is_array($maps)){
            foreach($maps as $map){
                $this->maps[] = new Map($map);
            }
        }else{
            $this->maps = $maps;
        }
    }

    public function setGametypes($gametypes){
        if(is_array($gametypes)){
            foreach($gametypes as $gametype){
                $this->gametypes[] = new Gametype($gametype);
            }
        }else{
            $this->gametypes = $gametypes;
        }
    }

    public function ToJSON():string{

        return json_encode($this->ToArray());
    }

    public function ToArray():array{
        $maps = array();
        $characters = array();
        $gametypes = array();

        foreach($this->maps as $map){
            $maps[] = $map->ToArray();
        }

        if(count($this->characters)){
            foreach($this->characters as $character){
                $characters[] = $character->ToArray();
            }
        }

        if(count($this->gametypes)){
            foreach($this->gametypes as $gametype){
                $gametypes[] = $gametype->ToArray();
            }
        }

        return [
            "name" => $this->name,
            "file" => $this->file,
            "characters" => $characters,
            "maps" => $maps,
            "gametypes" => $gametypes
        ];
    }
}