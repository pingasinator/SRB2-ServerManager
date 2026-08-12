<?php

define('Perm', 'sudo');

define('addonsFolder',"/root/.var/app/org.srb2.SRB2/.srb2/addons/");

function loadAll(){
    $path = "app/php/";

    $folders = scandir($path);
    foreach($folders as $folder){
        if($folder != "." && $folder != ".." && $folder != "api"){
            $files = scandir($path.$folder);
            foreach($files as $file){
                if($file != "." && $file != ".."){
                    require_once($path.$folder."/".$file);
                }
            }
        }
    }
}

function loadDefaultMaps(){
    if(file_exists("app/datas/maps.txt"))
    {
        $content =  file_get_contents("app/datas/maps.txt");
        $file_levels = explode("\nLevel ",$content);

        $levels = array();

        foreach($file_levels as $level){
            $level_content = explode("\n",$level);
            $level_data = array();
            $level_data['ID'] = $level_content[0];

            foreach($level_content as $row){
                $data = explode(" = ",$row);
                $data[0] = strtolower($data[0]);

                if(str_contains($data[1],",")){
                    $level_data[$data[0]] = explode(",",$data[1]);
                }else{
                    $level_data[$data[0]] = $data[1];
                }
            }
            $object_Level = new MAP($level_data);

            if($object_Level->getLevelname() != null){
                $levels[] = $object_Level->toArray();
            }
        }
        return $levels;
    }

    return null;
}

function loadDefaultGametypes(){
    $gametypes = array();
    $gametype = array();

    if(file_exists("app/datas/gametypes.txt"))
    {
        $content =  file_get_contents("app/datas/gametypes.txt");

        foreach(explode("\n",$content) as $row){
            $data = explode(" = ",strtolower($row));
            if(str_contains($data[0],"name")){
                if($gametype['name'] != null){
                    $gametypes[] = new Gametype($gametype);
                }
                $gametype = array();
                $data[1] = ucfirst($data[1]);

            }else if (str_contains($data[0],"typeoflevel"))
            {
                $data[1] = array(ucfirst($data[1]));
            }

            $gametype[$data[0]] = $data[1];

        }

        if($gametype['name'] != null){

            $gametypes[] = new Gametype($gametype);
        }
    }

    return $gametypes;
}

function loadDefaultCharacters(){
    $charactersNames = array(
        "None",
        "Sonic",
        "Tails",
        "knuckles",
        "Amy",
        "Fang",
        "MetalSonic"
    );

    $characters = array();

    foreach($charactersNames as $char){
        $characters[] = new Character(["skinName" => $char,"displayName" => $char]);
    }

    return $characters;
}