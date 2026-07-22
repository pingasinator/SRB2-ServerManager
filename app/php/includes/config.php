<?php

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