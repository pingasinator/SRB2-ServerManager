<?php

class ServerModel{

    /**
     * Creates a server, put it in a json file and starts it.
     *
     * @return array
     */
    function createServer(){
        $server = new server($_POST);

        $data = $server->ToJSON();
        $path = 'app/servers/'. $server->getName().'.json';
        file_put_contents($path, $data);

        $this->startServer($server->getName());

        return array("output" => "success", "code" => 0);
    }

    /**
     * Starts a Tmux session
     *
     * @param $name
     * @return array
     */
    function startServer($name){
        $path = "app/servers/{$name}.json";

        if(file_exists($path)){
            $data = file_get_contents($path);

            $server = new server(json_decode($data,true));

            $command = Perm . " tmux new-session -d -s srb2_{$server->getName()} 'flatpak run org.srb2.SRB2 -dedicated -port {$server->getPort()} -warp {$server->getMap()} -gametype {$server->getGameType()} -room {$server->getRoom()} " . ($server->getAllowDownload() === 'on' ? '' :'-noupload') ;
            if(count($server->getMods()) > 0){
                $command .= " -file ";
                $mods = $server->getMods();
                foreach($mods as $mod){

                    $command .= $mod . ".pk3 ";
                }
            }

            $motd = str_replace("'","'\''",$server->getMOTD());

            $command .= "+servername \"{$server->getDisplayName()}\" +password \"{$server->getPassword()}\" +forceskin {$server->getForceCharacter()} +maxplayers {$server->getMaxPlayers()} +motd \"{$motd}\" +timelimit {$server->getTimelimit()} +pointlimit {$server->getPointlimit()} ";

            if($server->getAllowDownload() === 'on'){
                $var = $server->getDownloadsize() * 1024;
                $command .= "+maxsend {$var}";
            }

            $command .= "' 2>/dev/null";
            exec($command,$output,$returncode);

            foreach($server->getCommands() as $command){
                $this->sendCommand($server->getName(),`{$command}`);
            }

            $this->getServerLog($server->getName());

            return array("output" => $output, "code" => $returncode);
        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

    /**
     * add an existing addon to the server
     *
     * @param $serverName
     * @param $addonName
     * @return array
     */
    function addAddon($serverName,$addonName){
        $serverFilePath = 'app/servers/'. $serverName .'.json';
        if(file_exists($serverFilePath)){
            $data = file_get_contents($serverFilePath);
            $server = new server(json_decode($data,true));
            $addonFilePath = 'app/addons/'. $addonName .'.json';
            if(file_exists($addonFilePath) && !in_array($addonName,$server->getMods())){

                $addons = $server->getMods();
                $addons[] = $addonName;
                $server->setMods($addons);
                if($this->updateServerConfig($server)){
                    $this->restartServer($server->getName());
                    return array("output" => "success", "code" => 0);
                }

            }else{
                return  array("output" => "error : Addon not found", "code" => 1);
            }

        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

    function listServerAddons($serverName){
        $serverFilePath = 'app/servers/'. $serverName .'.json';
        $addons = array();

        if(file_exists($serverFilePath)){
            $data = file_get_contents($serverFilePath);
            $server = new server(json_decode($data,true));
            foreach($server->getMods() as $mod){
                $addons[] = $this->getAddon($mod)->ToArray();
            }

            return $addons;
        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

    /**
     * restart the tmux session
     *
     * @param $serverName
     * @return array
     */
    function restartServer($serverName){
        $this->killServer($serverName);
         return $this->startServer($serverName);
    }

    /**
     * Lists all servers and their current states
     *
     * @return array
     */
    function ListServers(){

        $path = 'app/servers/';
        $files = scandir($path);
        $servers = array();
        foreach($files as $file){
            if($file != "." && $file != ".." && pathinfo($file, PATHINFO_EXTENSION) === "json"){
                $server = json_decode(file_get_contents($path. $file), true);
                $servers[] = [
                    "server" => $server,
                    "state" => $this->checkServerState($server['Name'])
                ];
            }
        }

        return $servers;
    }

    /**
     * Checks if a server has a session tmux
     *
     * @param $serverName
     * @return string
     */
    function checkServerState($serverName){
        $command = Perm . " tmux list-session | grep 'srb2_{$serverName}'";
        exec($command,$output,$returncode);
        return $returncode ? "inactive" : "active";
    }

    /**
     * kill the tmux session
     *
     * @param $serverName
     * @return array
     */
    function killServer($serverName){
        $this->getServerLog($serverName);
        $command = Perm . " tmux kill-session -t srb2_{$serverName}";
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    /**
     * kill the tmux session and delete the json file
     *
     * @param $name
     * @return string
     */
    function deleteServer($name){
        $this->killServer($name);
        if(file_exists('app/servers/'. $name .'.json')){
            unlink('app/servers/'. $name .'.json');
            unlink('app/logs/'. $name .'.log');
            return "successullly deleted <br>";
        }
        return "file not found";
    }

    /**
     * Mak an Instance of a server
     *
     * @param $name
     * @return server|string
     */
    function getServer($name){
        $path = 'app/servers/'. $name .'.json';
        if(file_exists($path)){
            $data = file_get_contents($path);
            $server = new server(json_decode($data,true));
            return $server;
        }

        return "error : Server file not found <br>";
    }

    /**
     * @param $serverName
     * @param $map
     * @param $gametype
     * @return array
     */
    function changeMap($serverName,$map,$gametype){
        $command = Perm . " tmux send-key -t srb2_{$serverName} ". escapeshellarg("map {$map}  -gametype \"{$gametype}\"\n");
        echo $command;
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    /**
     * send SRB2 command to the server
     *
     * @param $serverName
     * @param $command
     * @return array
     */
    function sendCommand($serverName,$command)
    {
        $command = Perm . " tmux send-key -t srb2_{$serverName} " . escapeshellarg("{$command}\n");
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    /**
     * Updates the server config in the json file
     *
     * @param $server
     * @return array|int
     */
    function updateServerConfig($server){
        $path = 'app/servers/'. $server->getName() .'.json';
        if(file_exists($path)){
            file_put_contents($path,$server->toJson());
            return 1;
        }
        return array("output" => "error : Server config file not found", "code" => 1);
    }

    /**
     * return all the defaults and custom maps of the server
     *
     * @param $serverName
     * @return array|null
     */
    public function listServerMaps($serverName){
        $defaultMaps = loadDefaultMaps();
        $customMaps = array();

        $server = $this->getServer($serverName);
        foreach($server->getMods() as $modName){

           $mod = $this->getAddon($modName);
           foreach($mod->getMaps() as $map){

               $customMap = new map($map);
               $customMaps[] = $customMap->toArray();
           }

        }

        $Maps = array_merge($defaultMaps,$customMaps);

        return $Maps;
    }

    public function getAddon($modName){
        $path = 'app/addons/'. $modName .'.json';
        if(file_exists($path)){
            $data = file_get_contents($path);
            $addon = new addon(json_decode($data,true));
            return $addon;
        }
    }



    public function listServerCharacters($serverName){
        $server = $this->getServer($serverName);
        $defaultCharacters = loadDefaultCharacters();
        foreach($server->getMods() as $modName){
            $mod = $this->getAddon($modName);
            foreach($mod->getCharacters() as $character){
                $defaultCharacters[] = $character;
            }
        }

        for($i = 0; $i < count($defaultCharacters); $i++){
            $defaultCharacters[$i] = $defaultCharacters[$i]->ToArray();
        }

        return $defaultCharacters;
    }

    public function forceCharacter($serverName,$skin)
    {
        $server = $this->getServer($serverName);
        $server->setForceCharacter($skin);
        if($this->updateServerConfig($server)){
            $command = Perm . " tmux send-key -t srb2_{$serverName} " . escapeshellarg("forceskin {$skin }\n");
            exec($command,$output,$returncode);
            return array("output" => $output, "code" => $returncode);
        }
        return array("output" => "error : Server config file not found", "code" => 1);
    }

    public function listServerGametypes($serverName){
        $server = $this->getServer($serverName);
        $addons = $server->getMods();
        $gametypes = loadDefaultGametypes();
        foreach($addons as $addonName){
            $addon = $this->getAddon($addonName);
            foreach($addon->getGametypes() as $gametype){
                $gametypes[] = new Gametype($gametype);
            }
        }

        for($i = 0; $i < count($gametypes); $i++){
            $gametypes[$i] = $gametypes[$i]->ToArray();
        }

        return $gametypes;
    }

    public function getServerGametype($serverName,$gametypeIdentifier){
        $gametypes = $this->listServerGametypes($serverName);
        foreach($gametypes as $gametype){
            if($gametype['identifier'] == $gametypeIdentifier){
                return $gametype;
            }
        }
    }

    public function removeServerAddon($serverName,$addonName){
        $path = 'app/servers/'. $serverName .'.json';
        if(file_exists($path)){
            $data = file_get_contents($path);
            $server = new server(json_decode($data,true));
            $addons = $server->getMods();
            $addon = $this->getAddon($addonName);

            if(in_array($addonName,$addons)){
                $key = array_search($addonName,$addons);
                array_splice($addons,$key,1);
            }

            foreach($addon->getCharacters() as $character){
                if($character->getSkinName() === $server->getForceCharacter()){
                    $server->setForceCharacter("None");
                }
            }

            $server->setMods($addons);
            $this->updateServerConfig($server);
            $this->restartServer($serverName);
            return array("output" => "Addon removed succesfully ", "code" => 0);
        }

        return array("output" => "error : Server config file not found", "code" => 1);
    }

    public function getServerMapsWithGameType($serverName,$gametypeName){
        $server = $this->getServer($serverName);
        $maps = $this->listServerMaps($serverName);
        $gametype = $this->getServerGametype($serverName,$gametypeName);
        $filteredMaps = array();
        foreach($maps as $map){
            foreach($map['TypeOfLevel'] as $typeOfLevel){
                foreach ($gametype["TypeOfLevel"] as $type){
                    if($typeOfLevel === $type){
                        $filteredMaps[] = $map;
                        break;
                    }
                }
            }
        }
        return $filteredMaps;
    }


    function getServerLog($serverName){
        $command = Perm . " tmux capture-pane -t srb2_{$serverName} -S - && " . Perm . " tmux save-buffer app/logs/{$serverName}.log";
        exec($command,$output,$returncode);
        $data = file_get_contents("app/logs/{$serverName}.log");
        return array("output" => $data, "code" => $returncode);
    }
}