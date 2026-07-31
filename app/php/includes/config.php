<?php

define('Perm', '');

const srb2_addons_folder = "/root/.var/app/org.srb2.SRB2/.srb2";


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
    if(file_exists("test.txt"))
    {
        $file = fopen("test.txt","r");
        $content =  fread($file,filesize("test.txt"));
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