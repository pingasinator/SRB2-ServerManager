<?php

class ServerModele {

    /**
     * Creates a server, put it in a json file and starts it.
     *
     * @return void
     */
    function createServer(){
        $server = new server($_POST);

        $data = $server->ToJSON();

        $file = fopen('app/servers/'. $server->getName().'.json',"w");
        fwrite($file, $data);
        fclose($file);

        $this->startServer($server->getName());
    }

    /**
     * Starts a Tmux session
     *
     * @param $name
     * @return array
     */
    function startServer($name){
        $path = 'app/servers/'. $name .'.json';

        if(file_exists($path)){
            $data = file_get_contents($path);

            $server = new server(json_decode($data,true));

            $command = Perm . " tmux new-session -d -s srb2_{$server->getName()} 'flatpak run org.srb2.SRB2 -dedicated -port {$server->getPort()} -warp {$server->getMap()} -gametype {$server->getGameType()}";
            if(count($server->getMods()) > 0){
                $command .= " -file ";
                $mods = $server->getMods();
                foreach($mods as $mod){

                    $command .= $mod . ".pk3 ";
                }
            }

            $command .= "' 2>/dev/null";
            exec($command,$output,$returncode);
            $this->sendCommand($server->getName(),"forceskin {$server->getForceCharacter()}");
            $this->sendCommand($server->getName(),"maxplayers {$server->getMaxPlayers()}");
            $this->sendCommand($server->getName(),"maxsend 248000");

            return array("output" => $output, "code" => $returncode);
        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

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
        if(file_exists($serverFilePath)){
            $data = file_get_contents($serverFilePath);
            $server = new server(json_decode($data,true));
            return $server->getMods();
        }else{
            return  array("output" => "error : Server file not found", "code" => 1);
        }
    }

    function restartServer($name){
        $this->killServer($name);
         return $this->startServer($name);
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
     * @param $name
     * @return array
     */
    function killServer($name){
        $command = Perm . " tmux kill-session -t srb2_" . $name;
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
            return "successullly deleted <br>";
        }
        return "file not found";
    }

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
        $command = Perm . " tmux send-key -t srb2_{$serverName} ". escapeshellarg("map {$map}  -gametype {$gametype}\n");
        echo $command;
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    function sendCommand($serverName,$command)
    {
        $command = Perm . " tmux send-key -t srb2_{$serverName} " . escapeshellarg("{$command}\n");
        exec($command,$output,$returncode);
        return array("output" => $output, "code" => $returncode);
    }

    function updateServerConfig($server){
        $path = 'app/servers/'. $server->getName() .'.json';
        if(file_exists($path)){
            $file = fopen($path,"w");
            fwrite($file, $server->toJSON());
            fclose($file);
            return 1;
        }
        return array("output" => "error : Server config file not found", "code" => 1);
    }

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

    function getServerConsole($serverName){

    }
}