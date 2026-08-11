<?php

class AddonModel {
    public function importAddon(){
        if(isset($_FILES["addon"]["name"])){
            if(!file_exists("app/tmp/" . $_FILES["addon"]["name"])){
                move_uploaded_file($_FILES["addon"]["tmp_name"], "app/tmp/" . $_FILES["addon"]["name"]);
            }

            $this->extractAddon();

            $characters = array();
            $maps = array();
            $gametypes = array();

            $path = "app/tmp/" . basename($_FILES["addon"]["name"],".pk3");

            $dirs = $this->loadDirs($path);

            $sockets = scandir($dirs['soc']);
            $luas = scandir($dirs['lua']);

            foreach($sockets as $socket){
                if($socket == "." || $socket == ".."){
                    continue;
                }

                $characters = array_merge($characters,$this->importCharacters($socket));

                $maps = array_merge($maps,$this->importMaps($socket));
            }

            foreach($luas as $lua){
                if($lua == "." || $lua == ".."){
                    continue;
                }

                $gametypes = array_merge($gametypes,$this->importGametypes($dirs['lua'] . "/" . $lua));
            }

            $content = array(
                "name" => basename($_FILES["addon"]["name"],".pk3"),
                "Characters" => $characters,
                "Maps" => $maps,
                "Gametypes" => $gametypes
            );

            $addon = new Addon($content);

            $file = fopen("app/addons/" . basename($_FILES["addon"]["name"],".pk3") . ".json", "w");
            fwrite($file, $addon->toJSON());
            fclose($file);

            $command = Perm . " cp -r app/tmp/" . $_FILES["addon"]["name"]. " " . addonsFolder;
            exec($command);

            $command = Perm . "rm -r app/tmp/*";
            exec($command);
        }
    }

    public function importCharacters($socket): array{
        $path = "app/tmp/" . basename($_FILES["addon"]["name"],".pk3") . "/SOC/" . $socket;
        if(file_exists($path)){
            $file = fopen($path, "r");
            $content =  fread($file,filesize($path));
            fclose($file);

            $file_rows = explode("\n",$content);
            $characters = array();
            $character = array();

            foreach($file_rows as $row){
                $row = strtolower(trim($row));
                if(str_starts_with($row, "Character")){
                    if($character['skinname'] != null){
                        $characters = new Character($character);
                        $character = array();

                    }

                }else{
                    $data =  explode(" = ",$row);
                    $character[$data[0]] = $data[1];
                }
            }

            if($character['skinname'] != null){
                $characters[] = new Character($character);
            }
            return $characters;
        }
        return [];
    }

    public function importMaps($socket): array{
        $path = "app/tmp/" . basename($_FILES["addon"]["name"],".pk3") . "/SOC/" . $socket;

        if(file_exists($path)){
            $file = fopen($path, "r");
            $content =  fread($file,filesize($path));
            fclose($file);
            $file_rows = explode("\n",$content);

            $levels = array();
            $level = array();

            foreach($file_rows as $row){
                $row = strtolower(trim($row));
                if(str_starts_with($row, "level ")){
                    if($level['ID'] != null){
                        $levels[] = new Map($level);
                        $level = array();
                    }

                    $data = explode("level ",$row);
                    $level['ID'] = $data[1];
                }else{
                    if($level['ID']  != null){
                        $data =  explode(" = ",$row);
                        if(str_contains($data[1], ",")){
                            $values = explode(",",$data[1]);
                            foreach ($values as $value){
                                $level[$data[0]][] = ucfirst($value);
                            }
                        }else{
                            $level[$data[0]] = ucfirst($data[1]);
                        }

                    }
                }
            }

            if($level['ID'] != null){
                $levels[] = new Map($level);
            }
            return $levels;
        }

        return [];
    }

    public function importGametypes($lua): array{
        $path = $lua;

        if(file_exists($path) && filesize($path) != 0){
            $file = fopen($path, "r");
            $content =  fread($file,filesize($path));
            fclose($file);
            $file_rows = explode("\n",$content);

            $gametypes = array();
            $gametype = array();

            if(str_contains($content,"G_AddGametype") || str_contains($content,"setmetatable")){
                foreach ($file_rows as $row){
                    $row = strtolower(trim($row));
                    if(str_starts_with($row, "g_addgametype") || str_starts_with($row, "setmetatable")){
                        if($gametype['name'] != null){
                            $gametypes[] = new Gametype($gametype);
                            $gametype = array();
                        }
                    }else{
                        $data =  explode(" = ",$row);
                        if(str_contains($data[1], "|")){
                            $values = explode("|",$data[1]);
                            foreach ($values as $value){
                                $chars = [",","\"","tol_"];
                                foreach ($chars as $char){
                                    if(str_contains($value, $char)){
                                        $value = str_replace($char,"",$value);
                                    }
                                }

                                $gametype[$data[0]][] = ucfirst($value);
                            }
                        }else{

                            $chars = [",","\"","tol_"];
                            foreach ($chars as $char){
                                if(str_contains($data[1], $char)){
                                    $data[1] = str_replace($char,"",$data[1]);
                                }
                            }

                            $gametype[$data[0]] = ucfirst($data[1]);
                        }
                    }
                }

                if($gametype['$identifier'] != null){
                    $gametypes[] = new Gametype($gametype);
                }
            }

            return $gametypes;
        }

        return [];
    }

    public function listAddons(): array{
        $dir = "app/addons/";
        $files = scandir($dir);
        $addons = array();
        foreach($files as $file){
            if($file != "." && $file != ".."){
                if(!is_dir($dir . $file)){
                    $f = fopen($dir . $file, "r");
                    $content = fread($f,filesize($dir . $file));
                    fclose($f);
                    $addon =  new Addon(json_decode($content));
                    $addons[] = $addon->ToArray();
                }
            }
        }
        return $addons;
    }

    public function extractAddon(){

        $archive = new ZipArchive();
        $archive->open("app/tmp/" . $_FILES["addon"]["name"]);
        mkdir("app/tmp/" . basename($_FILES["addon"]["name"],".pk3"));
        $archive->extractTo("app/tmp/" . basename($_FILES["addon"]["name"],".pk3"));
    }

    public function loadDirs($path):array{
        $folders = scandir($path);
        $dirs = array();
        foreach($folders as $folder){
            if($folder != "." && $folder != ".." && is_dir($path . "/" . $folder)){
                $dirs[strtolower($folder)] = $path . "/" . $folder;
            }
        }
        return $dirs;
    }
}